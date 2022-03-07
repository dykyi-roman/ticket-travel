<?php

declare(strict_types=1);

namespace Travel\Components\TicketTravel\UI\GraphQL\Segment\Query;

use Closure;
use GraphQL\Type\Definition\Type;
use Travel\Components\TicketTravel\Application\Segment\Seller\ArgumentResolver;
use Travel\Components\TicketTravel\Application\Segment\Seller\Resolver;
use Travel\Components\TicketTravel\Application\Segment\Seller\Responder;
use Travel\Components\TicketTravel\UI\GraphQL\Segment\Type\SellerType;

final class ListOfSellersQuery
{
    public function __construct(private Resolver $resolver, private Responder $responder)
    {
    }

    public function __invoke(array $documentation): array
    {
        return [
            'description' => $documentation['description'],
            'type' => Type::listOf(new SellerType()),
            'args' => [
                'value' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => $documentation['arguments']['value'],
                ],
            ],
            'resolve' => Closure::fromCallable([$this, 'resolve']),
        ];
    }

    private function resolve(mixed $root, array $args): array
    {
        return ($this->responder)(($this->resolver)(new ArgumentResolver($args)));
    }
}
