<?php

/*
 * This file is part of the NelmioApiDocBundle package.
 *
 * (c) Nelmio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nelmio\ApiDocBundle\Tests\Describer;

use Nelmio\ApiDocBundle\Describer\RouteDescriber;
use Nelmio\ApiDocBundle\RouteDescriber\RouteDescriberInterface;
use Nelmio\ApiDocBundle\Util\ControllerReflector;
use OpenApi\Annotations\OpenApi;
use OpenApi\Context;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteDescriberTest extends AbstractDescriberTest
{
    private $routes;

    private $routeDescriber;

    public function testIgnoreWhenNoController()
    {
        $this->routes->add('foo', new Route('foo'));
        $this->routeDescriber->expects(self::never())
            ->method('describe');

        self::assertEquals((new OpenApi(['_context' => new Context()]))->toJson(), $this->getOpenApiDoc()->toJson());
    }

    protected function setUp(): void
    {
        $this->routeDescriber = $this->createMock(RouteDescriberInterface::class);
        $this->routes = new RouteCollection();
        $this->describer = new RouteDescriber(
            $this->routes,
            new ControllerReflector(new Container()),
            [$this->routeDescriber]
        );
    }
}