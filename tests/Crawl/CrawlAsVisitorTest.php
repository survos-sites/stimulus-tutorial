<?php

namespace App\Tests\Crawl;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Survos\CrawlerBundle\Tests\BaseVisitLinksTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrawlAsVisitorTest extends BaseVisitLinksTest
{
	#[TestDox('/$method $url ($route)')]
	#[TestWith(['', '/admin', 200])]
	#[TestWith(['', '/cart', 200])]
	#[TestWith(['', '/cart/_list', 200])]
	#[TestWith(['', '/checkout', 200])]
	#[TestWith(['', '/label', 200])]
	#[TestWith(['', '/admin/product/', 200])]
	#[TestWith(['', '/admin/product/new', 200])]
	#[TestWith(['', '/', 200])]
	#[TestWith(['', '/reactive-cart', 200])]
	#[TestWith(['', '/register', 200])]
	#[TestWith(['', '/login', 200])]
	#[TestWith(['', '/product/105', 200])]
	#[TestWith(['', '/admin/product/112', 200])]
	#[TestWith(['', '/admin/product/112/edit', 200])]
	#[TestWith(['', '/admin/product/111', 200])]
	#[TestWith(['', '/admin/product/111/edit', 200])]
	#[TestWith(['', '/admin/product/110', 200])]
	#[TestWith(['', '/admin/product/110/edit', 200])]
	#[TestWith(['', '/buy_now/46?buyNow=1', 200])]
	public function testRoute(string $username, string $url, string|int|null $expected): void
	{
		parent::testWithLogin($username, $url, (int)$expected);
	}
}
