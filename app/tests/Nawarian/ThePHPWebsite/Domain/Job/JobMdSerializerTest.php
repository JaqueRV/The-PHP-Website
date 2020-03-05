<?php

declare(strict_types=1);

namespace Nawarian\ThePHPWebsite\Domain\Job;

use DateTime;
use PHPUnit\Framework\TestCase;

class JobMdSerializerTest extends TestCase
{
    public function testSerialize(): void
    {
        $createdAt = new DateTime();
        $job = new Job('1', 'my title', $createdAt, 'my body', 'My Source');

        $serializer = new JobMdSerializer();
        $result = $serializer->serialize($job);

        $expectedMd = <<<STR
---
slug: '1-my-title'
lang: 'pt-br'
createdAt: '{$createdAt->format('Y-m-d')}'
title: 'my title'
meta:
  description: 'my title'
  twitter:
    card: summary
    site: '@nawarian'
---

my body

Fonte: My Source
STR;

        self::assertEquals($expectedMd, $result);
    }

    public function testSerializeGrepsDescriptionFromMdRawBody(): void
    {
        $rawBody = <<<STR
## Descrição da vaga

Procuramos um(a) desenvolvedor(a) de Back com experiência em PHP, que goste de desafios e de resolver problemas.

## Local

Descrição do local...
STR;

        $createdAt = new DateTime();
        $job = new Job('1', 'my title', $createdAt, $rawBody, 'My Source');

        $serializer = new JobMdSerializer();
        $result = $serializer->serialize($job);

        $expectedMd = <<<STR
---
slug: '1-my-title'
lang: 'pt-br'
createdAt: '{$createdAt->format('Y-m-d')}'
title: 'my title'
meta:
  description: 'Procuramos um(a) desenvolvedor(a) de Back com experiência em PHP, que goste de desafios e de resolver problemas.'
  twitter:
    card: summary
    site: '@nawarian'
---

## Descrição da vaga

Procuramos um(a) desenvolvedor(a) de Back com experiência em PHP, que goste de desafios e de resolver problemas.

## Local

Descrição do local...

Fonte: My Source
STR;
        self::assertEquals($expectedMd, $result);
    }

    public function testSerializePreparesJobLabelsFromMdRawBody(): void
    {
        $rawBody = <<<STR
## Descrição da vaga

Uma descrição coisada de vaga e tal

## Labels

- CLT
- Pleno
- PHP
STR;
        $createdAt = new DateTime();
        $job = new Job('1', 'my title', $createdAt, $rawBody, 'My Source');

        $serializer = new JobMdSerializer();
        $result = $serializer->serialize($job);

        $expectedMd = <<<STR
---
slug: '1-my-title'
lang: 'pt-br'
createdAt: '{$createdAt->format('Y-m-d')}'
title: 'my title'
meta:
  description: 'Uma descrição coisada de vaga e tal'
  twitter:
    card: summary
    site: '@nawarian'
labels:
  - CLT
  - Pleno
  - PHP
---

## Descrição da vaga

Uma descrição coisada de vaga e tal

## Labels

- CLT
- Pleno
- PHP

Fonte: My Source
STR;

        self::assertEquals($expectedMd, $result);
    }
}
