<?php
namespace App\Lib;
class foreachPrintArr implements \Iterator
{
    //当前数组作用域
    private $_items;

    //保存每次执行数组环境栈
    private $_stack = array();

    public function __construct($data = array())
    {
        $this->_items = $data;
    }

    private function _isset()
    {
        return current($this->_items) ? true : false;
    }

    public function current()
    {
        $val = current($this->_items);

        //如果是数组则保存当前执行环境, 然后切换到新的数组执行环境
        if (is_array($val)) {
            array_push($this->_stack, $this->_items);
            $this->_items = $val;
            return $this->current();
        }

        return $val;
    }

    public function next()
    {
        //当前数组执行环境执行到最后,并且还存在上次未执行完的环境,则切换回来
        if (!next($this->_items) && !empty($this->_stack)) {
            $this->_items = array_pop($this->_stack);
            $this->next();
        }
    }

    public function key()
    {
        return key($this->_items);
    }

    public function rewind()
    {
        reset($this->_items);
    }

    public function valid()
    {
        return $this->_isset();
    }
}

