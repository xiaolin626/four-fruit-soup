<?php
/**
 * User : kevin.liu
 * Date : 2022/1/8 0008 下午 2:02
 * QQ : 791845283@qq.com
 * wechat : hanyi7918
 * Descript :
 */
namespace app\index\controller;
use think\Controller;

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;


class Paypal extends Controller
{
    public function paypal(){

        /**
         * Sandbox account
        sb-mmh4s11030611@business.example.com
         * client id:AbKhMiYvNTt4SUu743qOrauQYIsnM1EOgmmz3ZQmf7UE_IwL-_dY8FfZbmhImdrJ7tO6Ihc1eN6Ye1mC
         * secret:ELIFMhHSsaFVZz-B6q2rFclNTTpFf1WyYhMTXzsJVFYI1qx3R0z2L2Sf2gJzLTcaCcLVOAde-5q9seBj
         * webhook id：6DA52005RD9251357
         *
         * 商户号：sb-mmh4s11030611@business.example.com     密码：)?<h4M%V    手机号:2194475653     Account ID:8T8SRJSFNHCJE
         * 个人号：sb-gqqlm11025697@personal.example.com     密码：kGA5m%hm    手机号:2161835720     Account ID:47XQJGVB4JLY4
         */
    }

    protected $PayPal;
    protected $accept_url;//返回地址  可以带参数回调回来
    const Currency = 'USD'; //币种 美元


    public function __construct(){
        parent::__construct();
        $client_id='AbKhMiYvNTt4SUu743qOrauQYIsnM1EOgmmz3ZQmf7UE_IwL-_dY8FfZbmhImdrJ7tO6Ihc1eN6Ye1mC';
        $secret='ELIFMhHSsaFVZz-B6q2rFclNTTpFf1WyYhMTXzsJVFYI1qx3R0z2L2Sf2gJzLTcaCcLVOAde-5q9seBj';
        //创建支付对象实例
        $this->PayPal = new ApiContext(
            new OAuthTokenCredential($client_id,$secret)
        );
        $this->accept_url = 'https://'.$_SERVER['HTTP_HOST'].url('payNotice');
        //如果是沙盒测试环境不设置，请注释掉  正式环境打开
        // $this->PayPal->setConfig(
        //     array(
        //         'mode' => 'live',
        //     )
        // );
    }

    public function index(){
        $product = '四件套被子';
        $price = '1.2';
        $shipping = '0';
        $description = '商品描述';
        $this->pay($product, $price, $shipping, $description);
    }
    /**
     * @param
     * $product 商品
     * $price 价钱
     * $shipping 运费
     * $description 描述内容
     */
    public function pay($product, $price, $shipping = 0, $description)
    {
        $paypal = $this->PayPal;

        $total = $price + $shipping;//总价

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($product)->setCurrency(self::Currency)->setQuantity(1)->setPrice($price);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setShipping($shipping)->setSubtotal($price);

        $amount = new Amount();
        $amount->setCurrency(self::Currency)->setTotal($total)->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemList)->setDescription($description)->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        // $redirectUrls->setReturnUrl($this->accept_url . '?success=true')->setCancelUrl($this->accept_url . '/?success=false');
        $redirectUrls->setReturnUrl($this->accept_url .'?success=true')->setCancelUrl($this->accept_url .'?success=false');

        $payment = new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);
        try {
            $payment->create($paypal);
        } catch (PayPalConnectionException $e) {
            echo '222';
            echo $e->getData();
            die();
        }

        $approvalUrl = $payment->getApprovalLink();
       $this->redirect($approvalUrl);
        header("Location: {$approvalUrl}");
    }

    /**
     * 回调
     */
    public function payNotice()
    {
        // 修改订单状态
        $success = trim($_GET['success']);

        if ($success == 'false' && !isset($_GET['paymentId']) && !isset($_GET['PayerID'])) {
            echo "<script>alert('取消支付。');
                history.go(-4);
            </script>";
            exit();
        }

        $paymentId = trim($_GET['paymentId']);
        $PayerID = trim($_GET['PayerID']);

        if (!isset($success, $paymentId, $PayerID)) {
            echo 'Failure to pay。';
            exit();
        }

        if ((bool)$_GET['success'] === 'false') {
            echo 'Failure to pay，payment ID【' . $paymentId . '】,Payer ID【' . $PayerID . '】';
            exit();
        }

        $payment = Payment::get($paymentId, $this->PayPal);

        $execute = new PaymentExecution();

        $execute->setPayerId($PayerID);

        try {
            $payment->execute($execute, $this->PayPal);
        } catch (\Exception $e) {
            echo $e . ',支付失败，支付ID【' . $paymentId . '】,支付人ID【' . $PayerID . '】';
            exit();
        }

        // 到这里就支付成功了，可以修改订单状态，需要自己传参数，可以在成功回调地址后面加
        // code....


        // 可以跳转订单页面
        $url = url('/');
        echo 'finish';
    }
}