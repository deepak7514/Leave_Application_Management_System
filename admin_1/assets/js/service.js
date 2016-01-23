editProfile : function(details, $msg) { 
    views.showLoader();
    $.ajax({
      url : 'php/update_profile.php',
      data : details,
      method : 'post',
      dataType : 'json',
      success : function(r) {
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        views.profile();
        views.clearMessage($msg);
        views.closeModal();
        views.hideLoader();
      } 
    });
  },
getProfile : function($targets) { 
    views.showLoader();
    $.ajax({
      url : 'php/get_profile.php',
      dataType : 'json',
      success : function(r) {
        views.hideLoader();
        if(r.data) {
          console.log(r.data);
          service._profile = r.data;
          r.data.phoneNumbers = (r.data.phoneNumbers && r.data.phoneNumbers.length > 0) ? r.data.phoneNumbers.join(',') : 'N/A';
          views.renderByTargets(r.data, $targets);
        } else {
          window.location = 'index.php';
        }
      } 
    });
  },
  getProfileDetails : function() {
    return service._profile;
  }
};
