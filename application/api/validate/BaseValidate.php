<?php
namespace app\api\validate;
use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //必须设置contetn-type:application/json
        $request = Request::instance();
        $params = $request->param();
        if (!$this->check($params)) {
            $exception = new ParameterException(
                [
                    // $this->error有一个问题，并不是一定返回数组，需要判断
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]);
            throw $exception;
        }
        return true;
    }
}

?>