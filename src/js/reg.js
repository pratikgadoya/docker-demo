$(document).ready(function(){
	var fTable = $('#mytable').DataTable({
		"paginationType" : "full_numbers",
		"lengthMenu" : [5,10,15,20],
		"pageLength" : 10,
		"sDom": 'l<"#catdrop">frtip',
		"columnDefs" : [{
			"targets" : 0,
			"searchable" : false,
			"orderable" : false,
			"render" : function(data, type, full, meta){
				return "<center><input type='checkbox' name='selall[]' id='selall' class='check' value='"+full[1]+"'></center>"
				}
			},
			{
				"targets" : -1,
				"searchable" : false,
				"orderable" : false,
				"render" : function(data, type, full, row){
					return "<a href='registration.php?getedit=getedit&id="+full[1]+"'>Edit</a> | <a href='registration.php?id="+full[1]+"&del=del' onClick='return confirm(\"Are you sure you want to delete?\");'>Delete</a>"
				}
		}],

		"initComplete" : function(){
			this.api().column(7).every(function(){
				var colum = this;
				var catdrop = $('<Select><Option value="">All</Option</Select>').appendTo($('#catdrop'));
				var change = catdrop.on('change',function(){
					var value =$(this).val();
					colum.search(value);
					colum.draw();
				});
				colum.data().unique().sort().each(function(v){
					catdrop.append('<Option value="'+v+'">'+v+'</Option>')
				});
			});
		},

		"drawCallback" : function(){
			var pa = this.api().page.info();
			var prevpagerows = pa.prevPageRows;
			var nextpagerows = pa.nextPageRows;

			$('#mytable tfoot #prevpage').text(prevpagerows + " Records in Previous page");
			$('#mytable tfoot #nextpage').text(nextpagerows + " Records in Next page");
		}
	} );



	$('#selall').on('click',function(){
		    var row = fTable.rows({'search' : 'applied'}).nodes();
		 $('#selall',row).prop('checked',this.checked);
	});

	$('#mytable tfoot #del').html("<button onclick='deleteselected();' name='delsel'>Delete Selected</button>");


});

/*function tbl()
{
	// var tbl = document.getElementsByTagName("table");

	var row = document.getElementsByTagName("tr");

	for (var i = 0; i<row.length; i++) {
		if (i%2 == 0) {
			row[i].style.background = "yellow";
		}
		else
		{
			row[i].style.background = "green";
		}
	}
}*/


function validation(){

	var id=document.getElementById("id").value;
	var nm=document.getElementById("nm").value.trim();
	var unm=document.getElementById("unm").value.trim();
	var mail=document.getElementById("mail").value.trim();
	var pass=document.getElementById("pass").value.trim();
	var cpass=document.getElementById("cpass").value.trim();
	var mob=document.getElementById("mob").value.trim();
	var cat=document.getElementById("cat").value.trim();

	cat = cat.toUpperCase();

	var lpass= document.getElementById("pass").value.length;
	var vmob = /^([0]|\+[0-9]{1,3})?([0-9]{10})$/;
	var vmail = /^([a-zA-Z_]{1})+([a-zA-Z0-9\._-])+?@[a-zA-Z0-9_-]+\.[a-zA-Z0-9\.]{2,5}/;


	if (nm == "") {
		document.getElementById("error").innerHTML="Please Enter name";
		document.getElementById("nm").focus();
	}
	else if (unm == "") {
		document.getElementById("error").innerHTML="Please Enter Username...";
		document.getElementById("unm").focus();
	}
	else if(!vmail.test(mail) || mail == "")
	{
		document.getElementById("error").innerHTML="Please Enter Valide Email address...";
		document.getElementById("mail").focus();
	}
	else if (pass == "") {
		document.getElementById("error").innerHTML="Please Enter Password...";
		document.getElementById("pass").focus();
	}
	else if (lpass <6) {
		document.getElementById("error").innerHTML="Please Enter Minimum 6 Digits...";
		document.getElementById("pass").focus();
	}
	else if (pass != cpass) {
		document.getElementById("error").innerHTML="Password Doesn't Match...";
		document.getElementById("cpass").focus();
	}
	else if (!mob.match(vmob) || mob == "") {
		document.getElementById("error").innerHTML="Please Enter Valide Mobile Number...";
		document.getElementById("mob").focus();
	}
	else if (cat == "") {
		document.getElementById("error").innerHTML="Please Enter Categories...";
		document.getElementById("cat").focus();
	}

	else {
		if (id > 0) {
			window.location.href="registration.php?id="+ id +"&name=" + nm + "&uname=" + unm + "&email=" + mail + "&pass=" + cpass + "&mobile=" + mob + "&cat=" + cat + "&edit=edit";
		}
		else{
			window.location.href="registration.php?name=" + nm + "&uname=" + unm + "&email=" + mail + "&pass=" + cpass + "&mobile=" + mob + "&cat=" + cat + "&ins=ins";
		}
	}
}

//====================================================================

function resetall()
{
	document.getElementById("error").innerHTML="";

	var id=document.getElementById("id").value = "";
	var nm=document.getElementById("nm").value="";
	var unm=document.getElementById("unm").value="";
	var mail=document.getElementById("mail").value="";
	var pass=document.getElementById("pass").value="";
	var cpass=document.getElementById("cpass").value="";
	var mob=document.getElementById("mob").value="";
	var cat=document.getElementById("cat").value="";

	var url = document.location.href;
	var arr = url.split('?');
	arr.splice(1,1);
	url = arr.join('?');
	document.location.href = url;

}

// =======================================================================

function chkall(argument) {
	var all=document.getElementById("all").checked;
	var chk = document.getElementsByClassName("check");

	if (all) {

		for (var i = 0; i < chk.length; i++) {
			chk[i].checked = true;
		}
	}
	else
	{
		for (var i = 0; i < chk.length; i++) {
			chk[i].checked = false;
		}
	}
}

// ======================================== Delete selected ==================

function deleteselected()
{
	var getsel = document.getElementsByClassName("check");
	var sele = [];
	for(i=0;i<getsel.length;i++)
	{
		if (getsel[i].checked == true) {
			sele.push(getsel[i].value);
		}
	}

	if (sele == "" || sele == null)
	{
		alert("Please Select any one");
	}
	else
	{
		var conf= confirm("are you sure?");

		if (conf)
		{
			window.location.href="registration.php?delsel=delsel & sel="+sele;
		}
	}

}
// ====================================================================

function categories(cat,limit,srchvalue)
{
	window.location.href="registration.php?cat="+cat+"&srch="+srchvalue+"&limit="+limit;
}
