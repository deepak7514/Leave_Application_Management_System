function renderTable(data, ignore) {
  ignore = ignore || [];
  var html = "<table class='table table-bordered table-striped table-hover'>";
  var headers = "<thead> <tr>";
  var rows = "";

  for(var i in data[0]) {
    if(ignore.indexOf(i) < 0) {
      headers += ("<th>" + i.toUpperCase() + "</th>");
    } 
  } 
  html += (headers + '</tr></thead>');

  for(i = 0; i < data.length; i++) {
    rows += '<tr>';
    for(j in data[i]) {
      if(ignore.indexOf(j) < 0) {
        rows += ('<td>' + data[i][j] + '</td>');
      } 
    }
    rows += '</tr>';
  }
  html += rows;

  return html;
}
var service = { 
  addShop : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  addItem : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  addInvoice : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/add_shop',
      data : details,
      dataType : 'json',
      type : 'post',
      success : function(r) { 
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  getShops : function($target, ignore) {
    $.ajax({
		
      url : 'php/get_shops.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $target.html(r.msg);
        } else {
          $target.html(renderTable(r.data, ignore));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your shops</h4></div>");
      }
    });
  },
  getItems : function($target, ignore) {
    $.ajax({
      url : 'php/get_items.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $target.html(r.msg);
        } else {
          $target.html(renderTable(r.data, ignore));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your items</h4></div>");
      }
    });

  },
  getInvoices : function($target, ignore) {
    $.ajax({
      url : 'php/get_invoices.php',
      dataType : 'json',
      success : function(r) {
        if(r.error) {
          $target.html(r.msg);
        } else {
          $target.html(renderTable(r.data, ignore));
        }
      },
      error : function() {
        $target.html("<div class='alert alert-warning'><h4>:( We are facing troubles in fetching your invoices</h4></div>");
      }
    });

  },
  getAnalytics : function($target) {

  }
};
$(function() {
  $.ajax({
	url : 'php/myleaves.php',
	dataType : 'json',
	success : function(r) {		
	  if(!r.error) {
    	 console.log(r.data);
		 $('#leave-calendar').fullCalendar({
		   events : r.data
	     });	
	  }
	}
  });
});
