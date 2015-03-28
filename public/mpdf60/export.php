<?php
require_once('mpdf.php');
ob_start();

?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

<style type="text/css">
<!--
@page rotated { size: landscape; }
.style1 {
	font-family: "TH SarabunPSK";
	font-size: 18pt;
	font-weight: bold;
}
.style2 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	font-weight: bold;
}
.style3 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	
}
.style5 {cursor: hand; font-weight: normal; color: #000000;}
.style9 {font-family: Tahoma; font-size: 12px; }
.style11 {font-size: 12px}
.style13 {font-size: 9}
.style16 {font-size: 9; font-weight: bold; }
.style17 {font-size: 12px; font-weight: bold; }
-->
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
</head>
<body>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/css/jquery.simple-dtpicker.css')}}" />
		
	</head>
<table class="table table-striped table-bordered tabletest" border="1" style="font-size: 12px; ">
			<thead>
					
				<tr>
					<th rowspan="3">วันที่ทำการจู่โจม</th>
					<th text-rotate="90" rowspan="3"><div><span>เขต</span></div></th>
					<th text-rotate="90" rowspan="3" >เรือนจำ/ ทัณฑสถาน</th>
					<th text-rotate="90" rowspan="3"><div><span>จำนวนครั้งที่มีการจู่โจมกรณีปกติ</span></div></th>
					<th text-rotate="90" rowspan="3"><div><span>จำนวนครั้งที่มีการจู่โจมกรณีพิเศษ</span></div></th>
					<th rowspan="3">ไม่พบ</th>
					<th rowspan="3">พบ</th>
					<th colspan="23"><center>สิ่งของห้ามนำเข้าเรือนจำ/ทัณฑสถาน</center></th>
				</tr>
				<tr>
					<th colspan="6"><center>ยาเสพติดให้โทษ วัตถุออกฤทธิ์ต่อจิตและประสาท/สารระเหย</center></th>
					<th text-rotate="90" rowspan="2"><div><span>สุราหรือของมึนเมา</span></div></th>
					<th text-rotate="90" rowspan="2"><div><span>อุปกรณ์สำหรับเล่นการพนัน</span></div></th>
					<th text-rotate="90" rowspan="2"><div><span>เครื่องมืออันเป็นอุปกรณ์ในการหลบหนี</span></div></th>
					<th rowspan="2"><div><span>อาวุธ เครื่องกระสุนปืน วัตถุระเบิด ดอกไม้เพลิง และสิ่งเทียมอาวุธปืน</span></div></th>
					<th text-rotate="90" rowspan="2"><div><span>อาวุธดัดแปลง เหล็กแหลม</span></div></th>
					<th text-rotate="90" rowspan="2"><div><span>ของเน่าเสีย หรือของมีพิษต่อร่างกาย</span></div></th>
					<th text-rotate="90" rowspan="2"><div><span>น้ำมันเชื้อเพลิง</span></div></th>
					<th text-rotate="90" rowspan="2"><div><span>สัตว์มีชีวิต</span></div></th>
					<th colspan="7"><center>เครื่องคอมพิวเตอร์ โทรศัพท์มือถือ หรือเครื่องมือสื่อสารอื่น รวมทั้งอุปกรณ์สำหรับสิ่งของดังกล่าว</center></th>
					<th rowspan="2">วัตถุ เอกสารหรือสิ่งพิมพ์ซึ่งอาจก่อให้เกิดความไม่สงบเรียบร้อย หรือเสื่อมต่อศีลธรรมอันดีของประชาชน</th>
					<th rowspan="2">อื่นๆ</th>
				</tr>
				<tr>
					
					<th text-rotate="90"><div><span>ย้าบ้า(เม็ด)</span></div></th>
					<th text-rotate="90"><div><span>ไอซ์(กรัม)</span></div></th>
					<th text-rotate="90"><div><span>เฮโรอีน(กรัม)</span></div></th>
					<th text-rotate="90"><div><span>กัญชา(กรัม)</span></div></th>
					<th text-rotate="90"><div><span>ยาเมา(เม็ด)</span></div></th>
					<th text-rotate="90"><div><span>ฝิ่น(กรัม)</span></div></th>
					
					<th text-rotate="90"><div><span>เครื่องคอมพิวเตอร์</span></div></th>
					<th text-rotate="90"><div><span>โทรศัพท์มือถือ</span></div></th>
					<th text-rotate="90"><div><span>แบตเตอรี่</span></div></th>
					<th text-rotate="90"><div><span>ซิมการ์ด</span></div></th>
					<th text-rotate="90"><div><span>เมมโมรี่การ์ด</span></div></th>
					<th text-rotate="90"><div><span>หูฟัง/บลูธูท</span></div></th>
					<th text-rotate="90"><div><span>อุปกรณ์ชาร์จแบตเตอรี่</span></div></th>
				</tr>
				<?php
					$table = json_decode($_GET['table']);
					$table = json_decode($_GET['table']);
					//echo $_REQUEST['table'];
					foreach($table as $transaction)
					{
					?>
						<tr>
							<td><?=$transaction->found_date?></td>
							<td><?=($transaction->khet_id==10)? 'เขตอิสระ' : $transaction->khet_id?></td>
							
							<td><?=$transaction->location_id?></td>
					<?php if($transaction->method == 1) 
					{?>
							<td>1</td>	
							<td>-</td>		
					<?php  }
					 else { ?>
							<td>-</td>
							<td>1</td>	
					<?php } ?>
					<?php if($transaction->a+$transaction->b+$transaction->c+$transaction->d+$transaction->e+
							$transaction->f+$transaction->g+$transaction->h+$transaction->i+$transaction->j+
							$transaction->k+$transaction->l+$transaction->m+$transaction->n+$transaction->o+
							$transaction->p+$transaction->q+$transaction->r+$transaction->s+$transaction->t+
							$transaction->u+$transaction->v+$transaction->w == 0) 
							{?>
							<td>1</td>	
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
					<?php } 
					else  
					{
					?>
							<td>-</td>	
							<td>1</td>
							<td><?=($transaction->a==0)? '-' : $transaction->a?></td>
							<td><?=($transaction->b==0)? '-' : $transaction->b?></td>
							<td><?=($transaction->c==0)? '-' : $transaction->c?></td>
							<td><?=($transaction->d==0)? '-' : $transaction->d?></td>
							<td><?=($transaction->e==0)? '-' : $transaction->e?></td>
							<td><?=($transaction->f==0)? '-' : $transaction->f?></td>
							<td><?=($transaction->g==0)? '-' : $transaction->g?></td>
							<td><?=($transaction->h==0)? '-' : $transaction->h?></td>
							<td><?=($transaction->i==0)? '-' : $transaction->i?></td>
							<td><?=($transaction->j==0)? '-' : $transaction->j?></td>
							<td><?=($transaction->k==0)? '-' : $transaction->k?></td>
							<td><?=($transaction->l==0)? '-' : $transaction->l?></td>
							<td><?=($transaction->m==0)? '-' : $transaction->m?></td>
							<td><?=($transaction->n==0)? '-' : $transaction->n?></td>
							<td><?=($transaction->o==0)? '-' : $transaction->o?></td>
							<td><?=($transaction->p==0)? '-' : $transaction->p?></td>
							<td><?=($transaction->q==0)? '-' : $transaction->q?></td>
							<td><?=($transaction->r==0)? '-' : $transaction->r?></td>
							<td><?=($transaction->s==0)? '-' : $transaction->s?></td>
							<td><?=($transaction->t==0)? '-' : $transaction->t?></td>
							<td><?=($transaction->u==0)? '-' : $transaction->u?></td>
							<td><?=($transaction->v==0)? '-' : $transaction->v?></td>
							<td><?=($transaction->w==0)? '-' : $transaction->w?></td>
							<?php } ?>
						</tr>
					<?php }  ?>
					<tr>
						<td></td>
						<td></td>
						<td></td>

					<?php foreach($total as $temp)
					{ ?>
						<td><?=$temp?></td>
					<?php } ?>
					</tr>
				
			</thead>
		</table>
</body>
</html>
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');

$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>     
????????????????????? PDF <a href="MyPDF/MyPDF.pdf">??????????</a>
