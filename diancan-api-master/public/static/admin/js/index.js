/** index.js By Beginner Emain:zheng_jinfan@126.com HomePage:http://www.zhengjinfan.cn */
layui.config({
	base: '/static/admin/js/',
	version: true
}).use(['element', 'layer', 'navbar', 'tab'], function() {
	var element = layui.element(),
		$ = layui.jquery,
		layer = layui.layer,
		navbar = layui.navbar(),
		tab = layui.tab({
			elem: '.admin-nav-card' //设置选项卡容器
		});
	//iframe自适应
	$(window).on('resize', function() {
		var $content = $('.admin-nav-card .layui-tab-content');
		$content.height($(this).height() - 147);
		$content.find('iframe').each(function() {
			$(this).height($content.height());
		});
	}).resize();

	//设置navbar
	navbar.set({
		elem: '#admin-navbar-side',
		data: navs
		//url: 'datas/nav.json'
	});


	window.tab = tab;

	//渲染navbar
	if(navs.length >0 )
		navbar.render();
	//监听点击事件
	navbar.on('click(side)', function(data) {
		tab.tabAdd(data.field);
		var tabSession = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab") + ',' + data.field.title : data.field.title;
		if(!sessionStorage.getItem("tab") || sessionStorage.getItem("tab").indexOf(data.field.title)<0){
			sessionStorage.setItem("tab", tabSession);
		}
	});

	$('.admin-side-toggle').on('click', function() {
		var sideWidth = $('#admin-side').width();
		if(sideWidth === 200) {
			$('#admin-body').animate({
				left: '0'
			}); //admin-footer
			$('#admin-footer').animate({
				left: '0'
			});
			$('#admin-side').animate({
				width: '0'
			});
		} else {
			$('#admin-body').animate({
				left: '200px'
			});
			$('#admin-footer').animate({
				left: '200px'
			});
			$('#admin-side').animate({
				width: '200px'
			});
		}
	});

	//手机设备的简单适配
	var treeMobile = $('.site-tree-mobile'),
		shadeMobile = $('.site-mobile-shade');
	treeMobile.on('click', function() {
		$('body').addClass('site-mobile');
	});
	shadeMobile.on('click', function() {
		$('body').removeClass('site-mobile');
	});
});