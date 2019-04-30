<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出库单打印</title>
<meta name="keywords" content="Lodop、Lodop打印控件、WEB打印、C-Lodop、CLodop、lodop控件、云打印、手机打印、免费、AO打印">
<meta name="description" content="Lodop、Lodop打印控件、WEB打印、C-Lodop、CLodop、lodop控件、云打印、手机打印、免费、AO打印">
<script language="javascript" src="http://www.lodop.net/demolist/LodopFuncs.js"></script>
</head>
<body>
<div id="div1">

<style>td{border:1px solid #000;}</style>

<p><a href="javascript:PrintNoBorderTable();">预览打印</a>
</p>

<div id="div2">

<style>table,th{border:none;height:18px} td{border: 1px solid #000;height:18px}</style>

<table border=0 cellSpacing=0 cellPadding=0  width="100%" height="200" bordercolor="#000000" style="border-collapse:collapse">
<caption><b><font face="黑体" size="4">产品出库汇总清单</font></b><br></caption>
<thead>
  <tr>
    <th width="33%">日期：<?php echo ($data['info']['out_time']); ?></th>
    <th width="67%" colspan="2">单号:<?php echo ($data['info']['sn']); ?></th>
  </tr>
  <tr>
    <td width="16%"><b>货号</b></td>
    <td width="16%"><b>产品名称</b></td>
    <td width="16%"><b>颜色</b></td>
    <td width="16%"><b>规格</b></td>
    <td width="16%"><b>单价</b></td>
    <td width="16%"><b>数量</b></td>
  </tr>
</thead>
<tbody>
        <?php if(is_array($data['detail'])): $i = 0; $__LIST__ = $data['detail'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td width="16%"><?php echo ($vo["goods_sn"]); ?></td>
            <td width="16%"><?php echo ($vo["goods_name"]); ?></td>
            <td width="16%"><?php echo ($vo["color"]); ?></td>
            <td width="16%"><?php echo ($vo["size"]); ?></td>
            <td width="16%"><?php echo ($vo["price"]); ?></td>
            <td width="16%"><?php echo ($vo["out_num"]); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
</tbody>
<tfoot>
  
</tfoot>
</table>
</div>
<p>　
</p>

<script language="javascript" type="text/javascript"> 
	var LODOP; //声明为全局变量
        var iRadioValue=1;
	function PrintOneURL(){
		LODOP=getLodop();  
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_按网址打印表格");
		LODOP.ADD_PRINT_TBURL(46,90,800,300,document.getElementById("T1").value);
		LODOP.SET_PRINT_STYLEA(0,"HOrient",3);
		LODOP.SET_PRINT_STYLEA(0,"VOrient",3);
		LODOP.PREVIEW();			
	};	
	function PreviewMytable(){
		LODOP=getLodop();  
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_预览打印表格");
		LODOP.ADD_PRINT_TABLE(100,5,500,280,document.getElementById("div1").innerHTML);
		LODOP.SET_PRINT_STYLEA(0,"TableHeightScope",iRadioValue);		
		LODOP.PREVIEW();
	};	
	function DesignMytable(){
		LODOP=getLodop();  
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_打印设计表格");
		LODOP.ADD_PRINT_TABLE(100,5,500,280,document.getElementById("div1").innerHTML);
		LODOP.SET_PRINT_STYLEA(0,"TableHeightScope",iRadioValue);		
		LODOP.PRINT_DESIGN();
	};		
	function PrintInFullPage(){
		LODOP=getLodop();  
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_整页表格");
		LODOP.SET_PRINT_PAGESIZE(2,0,0,"A4");	
		LODOP.ADD_PRINT_TABLE("2%","1%","96%","98%",document.getElementById("div1").innerHTML);
		LODOP.SET_PREVIEW_WINDOW(0,0,0,800,600,"");
		LODOP.PREVIEW();				
	};	
	function PrintNoBorderTable(){
		LODOP=getLodop();  
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_无边线表格");
		LODOP.ADD_PRINT_TABLE(50,10,"50%",220,document.getElementById("div2").innerHTML);
		//LODOP.SET_PRINT_STYLEA(0,"Top2Offset",-40); //这句可让次页起点向上移
		
LODOP.SET_PRINT_STYLEA(0,"LinkedItem",-1);
		LODOP.PREVIEW();
	};		
	function check(thisValue){
	  iRadioValue=thisValue;
	}
</script>
		

</body>
</html>