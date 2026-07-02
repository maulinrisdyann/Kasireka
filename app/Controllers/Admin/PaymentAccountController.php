<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PaymentAccountModel;
class PaymentAccountController extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model=new PaymentAccountModel();
    }
    public function index()
    {
        return view('admin/payment/index',[
            'accounts'=>$this->model->findAll()
        ]);
    }
    public function store()
    {
        $this->model->insert([
            'type'=>$this->request->getPost('type'),
            'account_name'=>$this->request->getPost('account_name'),
            'account_number'=>$this->request->getPost('account_number'),
            'holder_name'=>$this->request->getPost('holder_name'),
            'is_active'=>1
        ]);
        return redirect()->back();
    }
}