<?php
declare(strict_types=1);

namespace MattyG\ArrayTransformer;

use InvalidArgumentException;

class ArrayTransformer
{
    /**
     * @var array
     */
    protected $transformations = array();

    /**
     * @param array $array
     * @return array
     */
    public function apply(array $array)
    {
        foreach ($this->transformations as $transformation) {
            $array = $transformation($array);
        }
        return $array;
    }

    /**
     * @param int $case
     * @return ArrayTransformer
     */
    public function changeKeyCase(int $case = CASE_LOWER)
    {
        $this->transformations[] = function(array $array) use ($case) {
            return array_change_key_case($array, $case);
        };
        return $this;
    }

    /**
     * @param int $size
     * @param bool $preserveKeys
     * @return ArrayTransformer
     */
    public function chunk(int $size, bool $preserveKeys = false)
    {
        $this->transformations[] = function(array $array) use ($size, $preserveKeys) {
            return array_chunk($array, $size, $preserveKeys);
        };
        return $this;
    }

    /**
     * @param string $columnKey
     * @param string|null $indexKey
     * @return ArrayTransformer
     */
    public function column($columnKey, $indexKey = null)
    {
        $this->transformations[] = function(array $array) use ($columnKey, $indexKey) {
            return array_column($array, $columnKey, $indexKey);
        };
        return $this;
    }

    /**
     * @param array[] $arrays
     * @return ArrayTransformer
     */
    public function diff(...$arrays)
    {
        $this->transformations[] = function(array $array) use ($arrays) {
            return array_diff($array, ...$arrays);
        };
        return $this;
    }

    /**
     * @param array[] $arrays
     * @return ArrayTransformer
     */
    public function intersect(...$arrays)
    {
        $this->transformations[] = function(array $array) use ($arrays) {
            return array_intersect($array, ...$arrays);
        };
        return $this;
    }

    /**
     * @param mixed|null $searchValue
     * @param bool $strict
     * @return ArrayTransformer
     */
    public function keys($searchValue = null, bool $strict = false)
    {
        $this->transformations[] = function(array $array) use ($searchValue, $strict) {
            return array_keys($array, $searchValue, $strict);
        };
        return $this;
    }

    /**
     * @param callable|null $callable
     * @param int $flag
     * @return ArrayTransformer
     */
    public function filter(callable $callable = null, int $flag = 0)
    {
        if ($callable) {
            $this->transformations[] = function(array $array) use ($callable, $flag) {
                return array_filter($array, $callable, $flag);
            };
        } else {
            $this->transformations[] = function(array $array) {
                return array_filter($array);
            };
        }
        return $this;
    }

    /**
     * @param callable $callable
     * @return ArrayTransformer
     */
    public function map(callable $callable)
    {
        $this->transformations[] = function(array $array) use ($callable) {
            return array_map($callable, $array);
        };
        return $this;
    }

    /**
     * @param array $mergeArray
     * @return ArrayTransformer
     */
    public function mergeLeft(array $mergeArray)
    {
        $this->transformations[] = function(array $array) use ($mergeArray) {
            return array_merge($mergeArray, $array);
        };
        return $this;
    }

    /**
     * @param array $mergeArray
     * @return ArrayTransformer
     */
    public function mergeRight(array $mergeArray)
    {
        $this->transformations[] = function(array $array) use ($mergeArray) {
            return array_merge($array, $mergeArray);
        };
        return $this;
    }

    /**
     * @param int $size
     * @param mixed value
     * @return ArrayTransformer
     */
    public function pad(int $size, $value)
    {
        $this->transformations[] = function(array $array) use ($size, $value) {
            return array_pad($array, $size, $value);
        };
        return $this;
    }

    /**
     * @param bool $preserveKeys
     * @return ArrayTransformer
     */
    public function reverse(bool $preserveKeys = false)
    {
        $this->transformations[] = function(array $array) use ($preserveKeys) {
            return array_reverse($array, $preserveKeys);
        };
        return $this;
    }

    /**
     * @param int $offset
     * @param int|null $length
     * @param bool $preserveKeys
     * @return ArrayTransformer
     */
    public function slice(int $offset, $length = null, bool $preserveKeys = false)
    {
        if ($length !== null && is_int($length) === false) {
            // Remove this when moving to PHP 7.1 which has nullable types
            throw new InvalidArgumentException('$length must be an integer, or null');
        }

        $this->transformations[] = function(array $array) use ($offset, $length, $preserveKeys) {
            return array_slice($array, $offset, $length, $preserveKeys);
        };
        return $this;
    }

    /**
     * @param int $sortFlags
     * @return ArrayTransformer
     */
    public function unique(int $sortFlags = SORT_STRING)
    {
        $this->transformations[] = function(array $array) use ($sortFlags) {
            return array_unique($array, $sortFlags);
        };
        return $this;
    }

    /**
     * @return ArrayTransformer
     */
    public function values()
    {
        $this->transformations[] = function(array $array) {
            return array_values($array);
        };
        return $this;
    }
}
