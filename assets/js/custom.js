/*
=========================================
|                                       |
|           Scroll To Top               |
|                                       |
=========================================
*/ 
$('.scrollTop').click(function() {
    $("html, body").animate({scrollTop: 0});
});


$('.navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ').click(function(e) {
    e.stopPropagation();
});

/*
=========================================
|                                       |
|       Multi-Check checkbox            |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

    var checker = $('#' + clickchk);
    var multichk = $('.' + relChkbox);


    checker.click(function () {
        multichk.prop('checked', $(this).prop('checked'));
    });    
}


/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

/*
    This MultiCheck Function is recommanded for datatable
*/

function multiCheck(tb_var) {
    tb_var.on("change", ".chk-parent", function() {
        var e=$(this).closest("table").find("td:first-child .child-chk"), a=$(this).is(":checked");
        $(e).each(function() {
            a?($(this).prop("checked", !0), $(this).closest("tr").addClass("active")): ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
        })
    }),
    tb_var.on("change", "tbody tr .new-control", function() {
        $(this).parents("tr").toggleClass("active")
    })
}

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

    var checker = $('#' + clickchk);
    var multichk = $('.' + relChkbox);


    checker.click(function () {
        multichk.prop('checked', $(this).prop('checked'));
    });    
}

/*
=========================================
|                                       |
|               Tooltips                |
|                                       |
=========================================
*/

$('.bs-tooltip').tooltip();

/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$('.bs-popover').popover();


/*
================================================
|                                              |
|               Rounded Tooltip                |
|                                              |
================================================
*/

$('.t-dot').tooltip({
    template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})


/*
================================================
|            IE VERSION Dector                 |
================================================
*/

function GetIEVersion() {
  var sAgent = window.navigator.userAgent;
  var Idx = sAgent.indexOf("MSIE");

  // If IE, return version number.
  if (Idx > 0) 
    return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));

  // If IE 11 then look for Updated user agent string.
  else if (!!navigator.userAgent.match(/Trident\/7\./)) 
    return 11;

  else
    return 0; //It is not IE
}




/*
================================================
|            Test Plan Step Definition         |
================================================
*/
function deleteItemRow() {
    deleteItem = document.querySelectorAll('.delete-item');
    for (var i = 0; i < deleteItem.length; i++) {
        deleteItem[i].addEventListener('click', function() {
            this.parentElement.parentNode.parentNode.parentNode.remove();
        })
    }
}

document.getElementsByClassName('additem')[0].addEventListener('click', function() {
    console.log('dfdf')
  
    getTableElement = document.querySelector('.item-table');
    currentIndex = getTableElement.rows.length;
  
    $html = '<tr>'+
    '<td class="delete-item-row">'+
        '<ul class="table-controls">'+
            '<li><a href="javascript:void(0);" class="delete-item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></li>'+
        '</ul>'+
      '</td>'+
      '<td class="description"><textarea class="form-control" placeholder="Step Definition" name="steps[]"></textarea></td>'+
      '<td class="description"><textarea class="form-control" placeholder="Expected Output" name="expected_output[]"></textarea></td>'+
      '</tr>';
  
    $(".item-table tbody").append($html);
    deleteItemRow();
  
  })
  
  deleteItemRow();




/*
================================================
|            Editable Table                    |
================================================
*/
  !function(a,b,c,d){function e(b,c){this.element=b,this.options=a.extend({},g,c),this._defaults=g,this._name=f,this.init()}var f="editable",g={keyboard:!0,dblclick:!0,button:!0,buttonSelector:".edit",maintainWidth:!0,dropdowns:{},edit:function(){},save:function(){},cancel:function(){}};e.prototype={init:function(){this.editing=!1,this.options.dblclick&&a(this.element).css("cursor","pointer").bind("dblclick",this.toggle.bind(this)),this.options.button&&a(this.options.buttonSelector,this.element).bind("click",this.toggle.bind(this))},toggle:function(a){a.preventDefault(),this.editing=!this.editing,this.editing?this.edit():this.save()},edit:function(){var b=this,c={};a("td[data-field]",this.element).each(function(){var d,e=a(this).data("field"),f=a(this).text(),g=a(this).width();if(c[e]=f,a(this).empty(),b.options.maintainWidth&&a(this).width(g),e in b.options.dropdowns){d=a("<select></select>");for(var h=0;h<b.options.dropdowns[e].length;h++)a("<option></option>").text(b.options.dropdowns[e][h]).appendTo(d);d.val(f).data("old-value",f).dblclick(b._captureEvent)}else d=a('<input type="text" />').val(f).data("old-value",f).dblclick(b._captureEvent);d.appendTo(this),b.options.keyboard&&d.keydown(b._captureKey.bind(b))}),this.options.edit.bind(this.element)(c)},save:function(){var b={};a("td[data-field]",this.element).each(function(){var c=a(":input",this).val();b[a(this).data("field")]=c,a(this).empty().text(c)}),this.options.save.bind(this.element)(b)},cancel:function(){var b={};a("td[data-field]",this.element).each(function(){var c=a(":input",this).data("old-value");b[a(this).data("field")]=c,a(this).empty().text(c)}),this.options.cancel.bind(this.element)(b)},_captureEvent:function(a){a.stopPropagation()},_captureKey:function(a){13===a.which?(this.editing=!1,this.save()):27===a.which&&(this.editing=!1,this.cancel())}},a.fn[f]=function(b){return this.each(function(){a.data(this,"plugin_"+f)||a.data(this,"plugin_"+f,new e(this,b))})}}(jQuery,window,document);

  $(function(){var e={};$(".table-edits tr").editable({dropdowns:{test_status:["Not Started","Passed","Failed"]},edit:function(t){$(".edit i",this).removeClass("fa-pencil-alt").addClass("fa-save").attr("title","Save")},save:function(t){$(".edit i",this).removeClass("fa-save").addClass("fa-pencil-alt").attr("title","Edit"),this in e&&(e[this].destroy(),delete e[this])},cancel:function(t){$(".edit i",this).removeClass("fa-save").addClass("fa-pencil-alt").attr("title","Edit"),this in e&&(e[this].destroy(),delete e[this])}})});