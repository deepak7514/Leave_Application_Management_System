// depends on service.js
var handlers = {
  modals : {
    deleteShow : function(e) {
      var id = e.relatedTarget.getAttribute('data-id');
      $(e.relatedTarget).parent().parent().addClass('delete-border');
      console.log($(e.currentTarget).find('.to-delete-id'));
      $(e.currentTarget).find('.to-delete-id').val(id);
    },
    deleteHide : function(e) {
      $('tr.delete-border').addClass('remove-border');
      setTimeout(function(){ 
        $('tr.delete-border').removeClass('remove-border');
        $('tr.delete-border').removeClass('delete-border');
      }, 250);
    },
    editShow : function(e) {
      views.clearMessage();
      views.clearModal();

      var $ele = $(e.currentTarget);
      switch(e.currentTarget.getAttribute('data-type')) {
        case 'shop' :
          var id = e.relatedTarget.getAttribute('data-id');
          $ele.find('.to-edit-id').val(id);
          views.renderByTargets(service.getShopDetails(id), {
            name : $ele.find('[name=name]'),
            state : $ele.find('[name=state]'),
            pin_code : $ele.find('[name=pin_code]'),
            address : $ele.find('[name=address]')
          });
          $(e.relatedTarget).parent().parent().addClass('edit-border');
          break;
        case 'item' :
          var id = e.relatedTarget.getAttribute('data-id');
          $ele.find('.to-edit-id').val(id);
          views.renderByTargets(service.getItemDetails(id), {
            name : $ele.find('[name=name]'),
            description : $ele.find('[name=description]'),
            cost_price : $ele.find('[name=cost_price]'),
            sell_price : $ele.find('[name=sell_price]'),
            mrp : $ele.find('[name=mrp]'),
            quantity : $ele.find('[name=quantity]')
          });
          $(e.relatedTarget).parent().parent().addClass('edit-border');
          break;
        case 'profile' :
          views.renderByTargets(service.getProfileDetails(), {
            firstName : $ele.find('[name=first-name]'),
            lastName : $ele.find('[name=last-name]'),
            phoneNumbers : $ele.find('[name=phoneNumbers]'),
            username : $ele.find('[name=username]'),
            owner_id : $ele.find('[name="owner_id"]')
          });
          break;
      }
    },
    editHide : function(e) {
      $('tr.edit-border').addClass('remove-border');
      setTimeout(function(){ 
        $('tr.edit-border').removeClass('remove-border');
        $('tr.edit-border').removeClass('edit-border');
      }, 250);
    },
    
  forms : {
    editProfile : function(e) {
      var $ele = $(e.currentTarget);
      var phoneNumbers = $ele.find('[name=phoneNumbers]').val();
      //TODO: add regex
      if(phoneNumbers === 'N/A' || phoneNumbers.replace(' ','', 'g') == "") {
        phoneNumbers = [];
      } else {
        phoneNumbers = phoneNumbers.split(',');
      }
      service.editProfile({
        owner_id : $ele.find('[name=owner_id]').val(),
        firstName : $ele.find('[name=first-name]').val(),
        lastName : $ele.find('[name=last-name]').val(),
        username : $ele.find('[name=username]').val(),
        phoneNumbers : phoneNumbers,
        oldPassword : $ele.find('[name=old-password]').val(),
        newPassword : $ele.find('[name=new-password]').val()
      }, $ele.find('.message'));
      e.isDefaultPrevented = true;
      return false;
    }
  }
  
  }
};
