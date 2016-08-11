发起支付请求
地址:http://pay.xiaohigh.com 
例子: http://pay.xiaohigh.com/api/deal?to=913588105@qq.com&money=200&order_id=112131231&info=2016款最新nike篮球鞋&return_url=http://www.xiaohigh.com?order_id=1212&status=1&money=200
参数
to :收款人的邮箱账号

money: 交易金额

order_id: 网站生成的订单id

info : 交易的文本提示

auth 验证字符串 (暂时不需要传递)

return_url 通知url http://www.xiaohigh.com/return_url

?order_id=12121&status=1&money=200 这参数会自动添加到url的后面