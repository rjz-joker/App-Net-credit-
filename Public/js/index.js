			$(document).ready(function(){
				$("#opt_money").on('input propertychange',function(){
					var nowSel = parseInt($(this).val() / stepMoney) * stepMoney;
					$("#show_money .cont_mtext").html(nowSel);
					//计算显示框位置
					var postion = (maxMoney-nowSel) / ((maxMoney-minMoney)/80);
					if(postion < 5){
						postion = 5;
					}
					if(postion > 90){
						postion = 90;
					}
					$("#show_money").attr('style','margin-right:'+postion+'%;');
					$(".cont_table_l .cont_mtext").html(nowSel);
				});
				$("#opt_day").on('input propertychange',function(){
					var nowSel = parseInt($(this).val());
					$("#show_day .cont_mtext").html(nowSel);
					//计算显示框位置
					var postion = (maxDay-nowSel) / ((maxDay-minDay)/85);
					if(postion < 5){
						postion = 5;
					}
					if(postion > 85){
						postion = 85;
					}
					$("#show_day").attr('style','margin-right:'+postion+'%;');
					$(".cont_table_r .cont_mtext").html(nowSel);
				});
			});