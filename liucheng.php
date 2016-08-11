1. 安装laravel框架  composer create-project laravel/laravel your-project-name --prefer-dist "5.1.*"
	将安装好的代码的文件夹拖至编辑器中.

2. 配置虚拟主机  cjz.com

3. 搭建后台页面.
	a) 添加路由规则  routes.php
	b) 解析模板   在方法中使用view
	c) 在指定的目录创建模板文件. 将目标模板中的代码复制到模板中.
	d) 将该模板需要的css,js,img文件复制到网站的根目录(这里建议做划分.Admin Home(index))
	e) 调整模板中的关于css和js以及img的路径.
	f) 调整模板中的内容. 删除一些无用的内容.修改汉字.

4. 创建页面表单的操作
	a) 继承页面
	b) 做页面标记
	c) 复制form标签元素的html字符串
	d) 修改form action地址  method方法  enctype属性
		form元素中的文本提示, name属性
	e) post表单中不要忘了加隐藏域 {{csrf_field()}}
5. 将数据插入到数据库中
	a) 表单验证.
		$this->validate($request, 验证规则(数组), 错误的信息提示(数组) );
		常用规则: required, same, email, regex, unique
		信息提示: [
					'username.required' =>'用户名不能为空'
					字段名称   验证规则		中文提醒
				]
	b) 对错误信息做显示操作, 
		在模板中使用标签
			@if (count($errors) > 0)
    		<div class="mws-form-message error">
            	<ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
            </div>
            @endif
    c) 数据处理
    	$data = $request->except();
    	$data = $request->only();

    d) 图片上传操作
    	1.检测图片是否存在.
    	2.拼接路径 (做配置是最合适的)  读取配置操作 config('app.upload_dir');
													函数	app(配置文件名称app.php)  upload_dir配置项的名称(数组键名)	

			关于配置: 如果是开发者的不同环境配置 (mysql, redis),建议在.env文件中配置
					  如果是网站的内部配置,(网站标题, 关键字, 描述, 上传目录.....), 建议到config下做配置. 一般都在app.php文件中配置即可.

		3.文件后缀获取 $request->file('profile')->getClientOriginalExtension();

	e) 存入数据库. 注意: 关于图片路径在存入数据库的时候, 要使用绝对路径.
		DB::table('users')->insert();
		表忘了导入类  
			use DB;
			use Hash;
6. 在laravel框架的方法中使用return 'abc' 的方式返给客户端字符串. 
	在普通代码中是不能使用这种方法来返回字符串.

7. 在数据库表中快速插入一些测试数据
	a) 创建一个类文件  
		php artisan make:seeder NameTableSeeder
	b) 到刚创建的文件中进行功能添加.   (/database/seeds/NameTableSeeder.php)
		在run方法中进行功能实现.
	c) 到database/seeds/DatabaseSeeder.php 中添加代码
		$this->call(UsersTableSeeder::class);
	d) 运行artisan命令
		php artisan db:seed

8. 做数据模板操作的时候, 将数据放置到js方便获取的位置是一个好是选择.

9. 数据列表操作.
	a) 读取数据
		where(function($query)use($request){
			if($request->input('keyword')){
				$query -> where('username','like','%'.$request->input('keyword').'%')
			}
		})
	b) 数据分页方法 paginate($num)

	c) 分配变量
			不要忘了将request对象分配过去.

	d) 如果页面的html代码格式很乱, 到网站中做格式化.
		http://tool.chinaz.com/Tools/JsFormat.aspx

	e) 内容调整.
		修改数字, 修改关键字.

	f) 数据分页页码.
		{!! $users -> appends($request->only())->render() !!}

	g) 如果页面显示的元素样式跟目标样式不同的话,
		先审核ok的模板元素样式.  在firebug的右侧会显示当前控制该元素的所有的css样式.
		将这些ok的css样式添加到我们的目标元素上可以了.

10. 更新操作
	a) 显示更新页面
		读取数据 DB::table()
		解析模板 return view();

	b) 推荐大家使用添加页面来做更新.
		修改标题  url地址  隐藏域  表单的元素值.

	c) 提交表单 将数据传递给服务器.
		获取参数 $request->except()
		根据条件(id)做更新  DB::table()->where()->update($data);

11. old函数只能用来读取 请求的参数   (old('username'))  
	如果要读取自定义的闪存数据 需要使用session函数  (session('info'))

12. 删除
	不要忽略了相关的附件的删除 (图片.)

13. 无限级分类的原理
	a) 如果是顶级分类(一级分类)  pid值为0  path为0
	b) 如果是子集分类  pid应该当前分类的父级分类的id , path的值应该父级分类的path+连接上父级分类的id

14. 清空数据 使用命令
	truncate cates.

15. 先创建控制器, 然后再书写路由规则.

16. shift+tab 回退tab水平制表符

17. Undefined variable: request

18.快速再次创建列表显示页面
	a) 将之前做好的列表显示页面的html模板内容, 复制过来.
	b) 调整当前模板页面中的相关参数. $request  $users
	c) 快速修改页面的报错信息
		快速打开文件  ctrl+ p
		快速定位指定的行  ctrl+g
		根据模板编译文件的报错, 找到模板的位置, 并将错误调整一下.

19. 无限级分类中的sql语句
	select *, concat(path, ',', id) as paths from cates order by paths
			   连接

20. 分类管理中  分类名称可以任意更改,但是结构尽量不要变(pid尽量不要更新) .

21. 使用navicat进行数据备份
		在数据名称上右键 -> 转存sql文件  -> 结构和数据
	如果要回复数据
		只需要将sql文件 拖入到navicat中即可.

22. 编辑器是一个js插件, 实现图文并茂的内容的管理.

23. 代码提示打开的方式 Preferences -> 设置 -用户 -> false ===>  true

23. 关于js插件的使用方式
	a) 看文档  

	b) 比猫画虎  (奏效快)

25. 编辑器的使用方式
	a) 将js代码引入操作放置到当前页面中. (将所需要的文件都复制到网站目录下.) 然后调整文件引入路径.
	b) 创建编辑器的容器元素.
	c) 执行js代码来创建编辑器.

25_2. 定制编辑器功能图标
	//定制工具栏的内容
		var ue = UE.getEditor('container', {
			toolbars: [
			    ['fullscreen', 'source', 'undo', 'redo', 'bold']
			]
		});

26. 如果多次更改代码, 但是始终发现页面不出效果, 第一时间反应 修改的文件是否正确.

27. 更改当前编辑器的样式(宽度和高度), 更改name属性,直接在标签上修改即可.

28. 在编辑器中修改文件上传的默认目录
	ueditor/php/config.json  ->  imagePathFormat  -> 自定义

	修改编辑器抓取图片的默认存放目录
	ueditor/php/config.json  ->  catcherPathFormat -> 自定义

29. 在laravel模板中发送ajax post请求的时候一定要注意, 不能忘了隐藏域
	解决方案
		a) 添加meta标签
			<meta name="csrf-token" content="{{ csrf_token() }}">
		b) 发送ajax请求之前, 做设置头信息的操作
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});	

30. 前后台的划分
	后台: 只有网站管理员可以访问的页面称为后台
	前台: 所有人都可以访问.

31. 在laravel框架中是可以直接书写php代码的.

32. 尽量保证前台用户访问的url是简洁.

33. 在laravel框架中 如果涉及session写入操作,千万不要使用dd  die,
	因为session的写入动作是在控制器代码之后的. 

34. 验证码的使用
	a) 修改composer.json文件, 在require里面添加
        "gregwar/captcha": "1.*"
	b) composer update
	c) 在控制器代码中 导入类
		use Gregwar\Captcha\CaptchaBuilder;

35. laravel框架中的自动验证.
	a) 创建类文件  php artisan make:request RegisterRequest 
	b) 在/app/Http/Requests/RegisterRequest 中调整代码
		修改方法authorize 将返回值改成true
	c) 在rules方法中填写验证规则
	d) 在messages方法中填写中文提醒.
	e) 在正在操作的控制器文件中引入该类
		在指定的方法中修改类型约束为当前的类.

36. 使用smtp的方式和来发送邮件 步骤
	a) 配置 (.env)
		MAIL_DRIVER=smtp
		MAIL_HOST=smtp.163.com
		MAIL_PORT=25
		MAIL_USERNAME=love_lamp@163.com
		MAIL_PASSWORD=abcd1234
		MAIL_ENCRYPTION=null

	b)  发送邮件
		Mail::send('emails.register', [], function ($m) {
            $m->from('love_lamp@163.com', 'lamp邮箱');
            $m->to('779498590@qq.com', 'xiaohigh')->subject('用户注册的激活邮件');
        });
    注意: 
    	1. 不能发送垃圾邮件. (内容不能太随意, 尽量写的重要一些. 验证码, 激活)
    	2. 不是所有的邮箱都可以发送smtp邮件.  (这里建议大家使用163邮箱)
    	3. 邮箱账号的获取步骤
    		a) 注册 , 登陆  
    		b) 点击上方的设置 -> POP3/SMTP/IMAP -> 勾选POP3/SMTP  IMAP/SMTP (绑定手机号)
    		c) 设置客户端密码  (有两个密码  一个登陆密码   一个是脚本发送邮件的密码) 
    			点击左侧的设置客户端密码  -> 开启 (输入手机验证码) -> 设置客户端密码(用来在脚本中发送邮件)
		4. 在发送验证邮件的时候,一定要加一个随机的验证字符串.
	
37. 如果页面打开的速度特别的慢
	a) 将firebug打开
	b) 到 网络 控制台查看一下  查看哪些连接请求比较慢一些, 然后在脚本中处理一下.
	c) fonts.google.com  (墙)

38. 伪静态
	看上去是静态的html文件, 但是实际上它不是.


39. 百度分享
	a) 到网站复制代码 share.baidu.com
	b) 将复制好的代码 放置到我们的网站页面中.

40. session的使用
	a) 可以使用手册中演示的方式   $request->session()->put() [get, push ...]
	b) 使用静态方法来实现  Session::put (get push)
	c) session(['uid'=>100])  session('uid')

41.待完善的内容
	a) 支付成功之后需要将购物车中的支付商品移出.;
	b) 在订单确认页面 应该有一个默认的收货地址.
	c) 在订单更新方法中,做表单验证
	d) 请求支付平台的时候 应该要加验证字符串, 防止用户篡改参数.(意识点)

42. 项目的构建流程
	a) ps设计图纸  ->  客户沟通 -> 切图 (将图片制作成静态的html文件)
	b) 套php程序.