<?php
namespace Mikan\Test;

use PHPUnit\Framework\TestCase;
use Mikan\Mikan;

class MikanTest extends TestCase
{
    private $instance;

    public function setUp()
    {
        $this->instance = new Mikan();
    }

    /**
     * @dataProvider providerSplit
     */
    public function testSplit($expected, $text)
    {
        $this->assertEquals($expected, $this->instance->split($text));
    }

    public function providerSplit()
    {
        return [
            [
                [
                    '常に',
                    '最新、',
                    '最高の',
                    'モバイル。',
                    'Androidを',
                    '開発した',
                    '同じ',
                    'チームから。',
                ],
                '常に最新、最高のモバイル。Androidを開発した同じチームから。',
            ],
            [
                [
                    '原稿と',
                    '防災服を',
                    '用意してくれ',
                ],
                '原稿と防災服を用意してくれ'
            ],
            [
                [
                    'やりたいことの',
                    'そばに',
                    'いる',
                ],
                'やりたいことのそばにいる',
            ],
            [
                [
                    'この',
                    'mikan.phpと',
                    'いう',
                    'ライブラリは、',
                    'スマートな',
                    '文字区切りを',
                    '可能にします。',
                ],
                'このmikan.phpというライブラリは、スマートな文字区切りを可能にします。',
            ],
            [
                [
                    '「あれ」',
                    'でもない、',
                    '「これ」',
                    'でもない。',
                ],
                '「あれ」でもない、「これ」でもない。',
            ],
            [
                [
                    '半角',
                    'スペース',
                    ' ',
                    '対応',
                ],
                '半角スペース 対応',
            ]
        ];
    }
}
