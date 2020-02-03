<?php

declare(strict_types=1);
/**
 * This file is part of TAnt.
 * @link     https://github.com/edenleung/think-admin
 * @document https://www.kancloud.cn/manual/thinkphp6_0
 * @contact  QQ Group 996887666
 * @author   Eden Leung 758861884@qq.com
 * @copyright 2019 Eden Leung
 * @license  https://github.com/edenleung/think-admin/blob/6.0/LICENSE.txt
 */

namespace app\admin\controller\system;

use app\BaseController;
use app\service\PermissionService;
use think\exception\ValidateException;

class Permission extends BaseController
{
    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * 规则列表.
     *
     * @param [type] $pageSize
     * @param [type] $pageNo
     * @return \think\Response
     */
    public function list($pageSize, $pageNo)
    {
        $result = $this->service->list((int) $pageNo, (int) $pageSize);
        return $this->sendSuccess($result);
    }

    /**
     * 添加规则.
     *
     * @return \think\Response
     */
    public function add()
    {
        $data = $this->request->param();

        try {
            $this->validate($data, [
                'name' => 'require|unique:permission',
                'title' => 'require',
                'pid' => 'require',
            ], [
                'pid.require' => '父级必须',
                'title.require' => '名称必须',
                'name.require' => '规则必须',
                'name.unique' => '规则重复',
            ]);
        } catch (ValidateException $e) {
            return $this->sendError($e->getError());
        }

        if ($this->service->add($data) === false) {
            return $this->sendError();
        }

        return $this->sendSuccess();
    }

    /**
     * 更新规则.
     *
     * @param [type] $id
     * @return \think\Response
     */
    public function renew($id)
    {
        $data = $this->request->param();
        
        try {
            $this->validate($data, [
                'name' => 'require|unique:permission',
                'title' => 'require',
                'pid' => 'require',
            ], [
                'pid.require' => '父级必须',
                'title.require' => '名称必须',
                'name.require' => '规则必须',
                'name.unique' => '规则重复',
            ]);
        } catch (ValidateException $e) {
            return $this->sendError($e->getError());
        }

        if ($this->service->renew($id, $this->request->param()) === false) {
            return $this->sendError();
        }

        return $this->sendSuccess();
    }

    /**
     * 删除规则.
     *
     * @param [type] $id
     * @return \think\Response
     */
    public function remove($id)
    {
        if ($this->service->remove($id) === false) {
            return $this->sendError();
        }

        return $this->sendSuccess();
    }
}
