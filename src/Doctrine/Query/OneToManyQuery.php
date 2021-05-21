<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Doctrine\Query;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Doctrine\DBAL\Query\QueryBuilder;
use Landingi\ApiBundle\Doctrine\Query;

// TODO Refactor this hell
final class OneToManyQuery implements Query
{
    public function getResult(QueryBuilder $queryBuilder): array
    {
        $connection = $queryBuilder->getConnection();
        $oneSideAlias = $queryBuilder->getQueryPart('from')[0]['alias'];
        $joinConditions = explode('=', $queryBuilder->getQueryPart('join')[$oneSideAlias][0]['joinCondition']);
        $joinTableName = $queryBuilder->getQueryPart('join')[$oneSideAlias][0]['joinTable'];
        list($oneSideJoinField) = array_values(array_filter($joinConditions, fn (string $condition) => str_contains($condition, "$oneSideAlias.")));
        list($manySideJoinField) = array_values(array_filter($joinConditions, fn (string $condition) => !str_contains($condition, "$oneSideAlias.")));
        $oneSideJoinField = trim($oneSideJoinField);
        $manySideJoinField = trim($manySideJoinField);
        $oneSideQuery = $this->withAliasOneSide($queryBuilder, $oneSideAlias);

        if (false === str_contains($this->getSelect($queryBuilder), $oneSideJoinField)) {
            $oneSideQuery->addSelect($oneSideJoinField);
        }

        $oneSideQueryResult = $connection->fetchAllAssociative(
            $oneSideQuery->getSQL(),
            $oneSideQuery->getParameters()
        );
        $oneToManyField = trim($oneSideJoinField, "$oneSideAlias.");
        $manySideParameters = array_column($oneSideQueryResult, $oneToManyField);

        $manySideQuery = $this->withAliasManySide($queryBuilder, $oneSideAlias);

        if (false === str_contains($this->getSelect($manySideQuery), $manySideJoinField)) {
            $manySideQuery->addSelect($manySideJoinField);
        }

        $manySideQuery->andWhere(
            $manySideQuery->expr()->in(
                $manySideJoinField,
                $manySideParameters
            )
        );
        $manySideAlias = $manySideQuery->getQueryPart('from')[0]['alias'];
        $manyToOneField = trim($manySideJoinField, "$manySideAlias.");
        $manySideQueryResult = $connection->fetchAllAssociative(
            $manySideQuery->getSQL(),
            $manySideQuery->getParameters()
        );

        return $this->mergeResults(
            $oneSideQueryResult,
            $oneToManyField,
            $manySideQueryResult,
            $manyToOneField,
            $joinTableName
        );
    }

    private function withSelect(QueryBuilder $queryBuilder, string $alias): QueryBuilder
    {
        $clone = clone $queryBuilder;
        $clone->select(
            implode(
                ',',
                array_filter(
                    explode(',', $this->getSelect($queryBuilder)),
                    fn (string $part) => str_contains($part, "$alias.")
                )
            )
        );

        return $clone;
    }

    private function withWhere(QueryBuilder $queryBuilder, string $alias): QueryBuilder
    {
        $clone = clone $queryBuilder;
        /** @var CompositeExpression $where */
        $where = $queryBuilder->getQueryPart('where');
        $clone->where(
            implode(
                $where->getType(),
                array_filter(
                    explode($where->getType(), (string) $where),
                    fn (string $part) => str_contains($part, "$alias.")
                )
            )
        );

        return $clone;
    }

    private function withOrderBy(QueryBuilder $queryBuilder, string $alias): QueryBuilder
    {
        $clone = clone $queryBuilder;
        $clone->resetQueryPart('orderBy');

        foreach ($queryBuilder->getQueryPart('orderBy') as $item) {
            [$field, $direction] = explode(' ', $item);

            if (str_starts_with($field, "$alias.")) {
                $clone->addOrderBy($field, $direction);
            }
        }

        return $clone;
    }

    private function getSelect(QueryBuilder $queryBuilder): string
    {
        return implode(',', $queryBuilder->getQueryPart('select'));
    }

    private function mergeResults(array $oneSideResult, string $oneSideField, array $manySideResult, string $manySideField, string $joinField): array
    {
        $result = $oneSideResult;

        foreach ($result as &$oneSide) {
            foreach ($manySideResult as $manySide) {
                if ($oneSide[$oneSideField] === $manySide[$manySideField]) {
                    $oneSide[$joinField][] = $manySide;
                }
            }
        }

        return $result;
    }

    private function withAliasOneSide(QueryBuilder $queryBuilder, string $alias): QueryBuilder
    {
        $clone = clone $queryBuilder;
        $clone->resetQueryPart('join');
        $clone = $this->withSelect($clone, $alias);
        $clone = $this->withWhere($clone, $alias);

        return $this->withOrderBy($clone, $alias);
    }

    private function withAliasManySide(QueryBuilder $queryBuilder, string $alias): QueryBuilder
    {
        $clone = clone $queryBuilder;
        $joinAlias = $clone->getQueryPart('join')[$alias][0]['joinAlias'];
        $clone = $this->withSelect($clone, $joinAlias);
        $clone->resetQueryPart('from');
        $clone->from($clone->getQueryPart('join')[$alias][0]['joinTable'], $joinAlias);
        $clone->resetQueryPart('join');
        $clone = $this->withWhere($clone, $joinAlias);
        $clone->setMaxResults(null);
        $clone->setFirstResult(0);

        return $this->withOrderBy($clone, $joinAlias);
    }
}
