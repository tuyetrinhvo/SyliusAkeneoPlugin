<?php

declare(strict_types=1);

namespace Tests\Synolia\SyliusAkeneoPlugin\PHPUnit\Api;

use Akeneo\Pim\ApiClient\AkeneoPimClientBuilder;
use Akeneo\Pim\ApiClient\AkeneoPimClientInterface;
use Akeneo\Pim\ApiClient\Api\AuthenticationApi;
use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;
use donatj\MockWebServer\ResponseStack;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\Assert;

abstract class ApiTestCase extends TestCase
{
    private const SAMPLE_PATH = '/datas/sample/';

    /** @var MockWebServer */
    protected $server;

    protected function setUp(): void
    {
        $this->server = new MockWebServer(8081, '127.0.0.1');
        $this->server->start();

        $this->server->setResponseOfPath(
            '/' . AuthenticationApi::TOKEN_URI,
            new ResponseStack(
                new Response($this->getAuthenticatedJson())
            )
        );
    }

    protected function tearDown(): void
    {
        $this->server->stop();
    }

    protected function createClient(): AkeneoPimClientInterface
    {
        $clientBuilder = new AkeneoPimClientBuilder($this->server->getServerRoot());

        return $clientBuilder->buildAuthenticatedByPassword(
            'client_id',
            'secret',
            'username',
            'password'
        );
    }

    protected static function getSamplePath(): string
    {
        return \dirname(__DIR__) . self::SAMPLE_PATH;
    }

    protected function getFileContent(string $name): string
    {
        $file = self::getSamplePath() . $name;
        Assert::fileExists($file);

        $content = \file_get_contents($file);
        if (false === $content) {
            return '';
        }

        return $content;
    }

    private function getAuthenticatedJson(): string
    {
        return <<<JSON
            {
                "refresh_token" : "refresh-token",
                "access_token" : "access-token"
            }
JSON;
    }
}