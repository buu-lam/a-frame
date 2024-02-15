<?php

namespace Af\Type\Format;

use \Af\Type\Arr;

class SortTest extends \Codeception\Test\Unit {


    public function testSort() {
        $arr = new Arr([4, 3, 5]);
        expect($arr->sort()->get())->toBe([3, 4, 5]);
        expect($arr->get())->toBe([3, 4, 5]);
    }

    public function testRSort() {
        $arr = new Arr([4, 3, 5]);
        expect($arr->rsort()->get())->toBe([5, 4, 3]);
        expect($arr->get())->toBe([5, 4, 3]);
    }
    
    public function testNatSort() {
        $arr = new Arr(['img11', 'img101', 'img2']);
        expect($arr->natSort()->get())->toBe([2 => 'img2', 0 => 'img11', 1 => 'img101']);
        expect($arr->get())->toBe([2 => 'img2', 0 => 'img11', 1 => 'img101']);
    }
    
    public function testUSort() {
        $arr = new Arr([
            (object) ['a' => 3],
            (object) ['a' => 2]
        ]);
        $array1 = $arr->usort(fn($o1, $o2) => $o1->a <=> $o2->a)->get();
        $array2 = $arr->get();
        expect($array1[0]->a)->toBe(2);
        expect($array1[1]->a)->toBe(3);
        expect($array2[0]->a)->toBe(2);
        expect($array2[1]->a)->toBe(3);
    }
    
}
