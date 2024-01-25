<?php

namespace Af\Type;

class ArrTest extends \Codeception\Test\Unit {
    
    public function testOffset() {
        $array = ['a', 'b', 'c'];
        $arr = new Arr($array);
        expect($arr[1])->toEqual('b');
        $arr[1] = 'z';
        expect($arr[1])->toEqual('z');
        $arr[] = 'd';
        expect($arr[3])->toEqual('d');
        unset($arr[3]);
        expect($arr[3])->toBeNull();
    }
    
    public function testGetIterator() {
        $array = ['a', 'b', 'c'];
        $arr = new Arr($array);
        $keys = '';
        $values = '';
        foreach($arr as $key => $value) {
            $keys .= $key;
            $values .= $value;
            expect($value)->toEqual(current($array));
            expect($key)->toEqual(key($array));
            next($array);
        }
        expect($keys)->toEqual('012');
        expect($values)->toEqual('abc');
    }
    
    public function testExtract() {
        $arr = new Arr(['a' => 1, 'b' => 2]);
        list($b, $a) = $arr->extract('b', 'a');
        expect($a)->toBe(1);
        expect($b)->toBe(2);
    }

    public function testFilter() {
        $arr = new Arr(['a' => 1, 'b' => 2, 'c' => 3]);
        $filtered = $arr->filter(function ($value) {
            return ($value % 2);
        });
        expect($filtered)->notToEqual($arr);
        expect($filtered->get())->toEqual(['a' => 1, 'c' => 3]);
    }

    public function testImplode() {
        $arr = new Arr(['a' => 'y', 'b' => 'e', 'c' => 's']);
        $imploded = $arr->implode('');
        expect($imploded)->toBeInstanceOf(Str::class);
        expect($imploded->get())->toEqual('yes');
    }

    public function testInArray() {
        $arr = new Arr([1, 2, 3]);
        expect($arr->inArray(1))->toBeTrue();
        expect($arr->inArray(0))->toBeFalse();
        expect($arr->inArray('3'))->toBeTrue();
        expect($arr->inArray('3', true))->toBeFalse();
    }
    
    public function testJoin() {
        $arr = new Arr(['a' => 'y', 'b' => 'e', 'c' => 's']);
        $joined = $arr->join('-');
        expect($joined)->toBeInstanceOf(Str::class);
        expect($joined->get())->toEqual('y-e-s');
    }

    public function testKeyExists() {
        $arr = new Arr(['a' => 1, 'b' => 2]);
        expect($arr->keyExists('a'))->toBeTrue();
        expect($arr->keyExists('c'))->toBeFalse();
    }

    public function testMap() {
        $arr = new Arr(['a' => 1, 'b' => 2, 'c' => 3]);
        $mapped = $arr->map(function ($value) {
            return $value * 2;
        });
        expect($mapped)->notToEqual($arr);
        expect($mapped->get())->toEqual(['a' => 2, 'b' => 4, 'c' => 6]);
    }

    public function testPop() {
        $arr = new Arr([1, 2, 3]);
        expect($arr->pop())->toBe(3);
        expect($arr->get())->toBe([1, 2]);
    }
 
    public function testPush() {
        $arr = new Arr([1, 2, 3]);
        $arr->push(4);
        expect($arr->get())->toBe([1, 2, 3, 4]);
        $arr->push(5, 6);
        expect($arr->get())->toBe([1, 2, 3, 4, 5, 6]);
    }
    
    public function testSearch() {
        $arr = new Arr(['a', 'b', 'c', '12', 45 => 'specific-index', 'string-index' => 7]);
        expect($arr->search('a'))->toBe(0);
        expect($arr->search('b'))->toBe(1);
        expect($arr->search('not-here'))->toBe(false);        
        expect($arr->search(12))->toBe(3);
        expect($arr->search(12, false))->toBe(3);
        expect($arr->search('12', true))->toBe(3);
        expect($arr->search('specific-index'))->toBe(45);
        expect($arr->search(7))->toBe('string-index');
    }

    public function testShift() {
        $arr = new Arr([1, 2, 3]);
        expect($arr->shift())->toBe(1);
        expect($arr->get())->toBe([2, 3]);
    }
    
    public function testUnique() {
        $arr = new Arr([2, 4, 1, 2, 3, 4, 5]);
        expect($arr->unique()->get())->toBe([0 => 2, 1 => 4, 2 => 1, 4 => 3, 6 => 5]);
    }
    
    
    public function testUnshift() {
        $arr = new Arr([3, 4]);
        $arr->unshift(1, 2);
        expect($arr->get())->toBe([1, 2, 3, 4]);
    }
    
    public function testValues() {
        $arr = new Arr([0 => 2, 1 => 4, 2 => 1, 4 => 3, 6 => 5]);
        expect($arr->values()->get())->toBe([2, 4, 1, 3, 5]);
    }
    
    public function testKeys() {
        $arr = new Arr([0 => 2, 1 => 4, 2 => 1, 4 => 3, 6 => 5]);
        expect($arr->keys()->get())->toBe([0, 1, 2, 4, 6]);
    }
    
    public function testCombine() {
        expect((new Arr(['foo', 'bar']))->combine([0, 1])->get())->toBe(['foo' => 0, 'bar' => 1]);
        expect((new Arr(['foo', 'bar']))->combine((new Arr([0, 1])))->get())->toBe(['foo' => 0, 'bar' => 1]);
    }
    
    public function testCount() {
        $arr = new Arr([0 => 2, 1 => 4, 2 => 1, 4 => 3, 6 => 5]);
        expect($arr->count())->toBe(5);
        expect(count($arr))->toBe(5);
    }
    
    public function testMerge() {
        $arr1 = new Arr([1, 2, 3]);
        $arr2 = $arr1->merge([4, 5], [6, 7]);
        expect($arr2->get())->toBe([1, 2, 3, 4, 5, 6, 7]);
    }
    
    public function testMergeRecursive() {
        $arr1 = new Arr(['a' => 1, 'b' => 2, 'c' => ['d' => 3]]);
        $arr2 = $arr1->mergeRecursive(['c' => ['e' => 4]]);
        expect($arr2->get())->toBe([
            'a' => 1, 
            'b' => 2, 
            'c' => [
                'd' => 3,
                'e' => 4
            ]])
        ;
    }
}
