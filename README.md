# maoerpay

MaoerPay PHP SDK

猫耳支付微信个人免签接口，微信官方直连。一切违法法律的项目拒绝接入。

官方在线文档：http://doc.maoer.net.cn

#### 安装(PHP>=5.6)开发版
> composer require maoer/pay dev-master

#### 示例

    <?php
      require_once 'src/vendor/autoload.php';
      use MaoerPay\Trade;
      $config = [
        'mch_id'=>'你的微信商户号',
        'PRIVATE_KEY'  => '你的私钥文本'
      ];
      $trade = new Trade($config);
      $params = [
          'code'=>'134876110602341382', //用户付款码
          'body'=>'支付调试', //订单描述
          'out_trade_no'=>'20191109164425364997', //自定义的订单号
          'total_fee'=>1  //支付金额，单位是分，传递1表示支付1分钱
      ];
      print_r($trade->barpay($params));//提交付款码支付
      print_r($trade->order_query(['out_trade_no'=>'20191109164425364997']));//查询刚刚提交的订单
      ?>
