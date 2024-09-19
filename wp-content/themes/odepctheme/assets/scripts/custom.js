function filterData(page){

  if(page == undefined){
    page = 0;
  }

  $('.no-result').remove();
 
  
  var keywordSearch = $('#keywordSearch').val();
  var countryState = $('#countryState').val();

  var recordsPerPage = $('#recordsPerPage').val();
  var sortBy = $('#sortBy').val();

  var jobType = $('#jobType').val();
  var industry = $('#industry').val();
  var gender = $('#gender').val();

  var country = $('#country').val();
  var state = $('#state').val();
  
  var datePosted = $('input[name="datePosted"]:checked').attr('id');

  var data = {
    action: 'job_result', 
    page: page,
    keywordSearch: keywordSearch,
    countryState: countryState,
    sortBy: sortBy,
    recordsPerPage: recordsPerPage,
    jobType: jobType,
    industry: industry,
    gender: gender,
    country: country,
    state: state,
    datePosted: (datePosted != undefined) ? datePosted : ''
  }

  $.ajax({
    type : 'post',
    url : ajaxurl,
    async : true,
    dataType : 'json',
    data: data,
    success: function(response) {
      $('#jobData').empty().append(response.html_content);
      $('#resultStatus').empty().append(response.result_status);
      $('#jobPagination').empty().append(response.pagination);
    },
    error: function(response){
      $('#jobData').empty().append(response);
      $('#jobData .load-spinner').remove();
    }
  });
  
}

function countryFilter($categorySelect, $subCategorySelect) {
  $subCategorySelect.parent().hide();
  var categories = $.map(terms, function(value, index) {
    return [value];
  });

  var $default_cat = '<option value="" disabled selected>Country</option>'; 
  $categorySelect.prepend($default_cat);
  categories.forEach(function(category) {
    var $option = $('<option/>').attr('value', category.term_id).html(category.name);
    $categorySelect.append($option);
  });

  $categorySelect.on('change', function() {
    $subCategorySelect.empty();
    var selectedCategoryValue = $categorySelect.val();
    var category = categories.find(function(category) {
        return category.term_id == selectedCategoryValue;
    });
    if (category) {
      var subCategories = $.map(category.children, function(value, index) {
        return [value];
      });

      var $default_subcat = '<option value="" disabled selected>State</option>'; 
      $subCategorySelect.prepend($default_subcat);
      subCategories.forEach(function(subcategory) {
        var $option = $('<option/>').attr('value', subcategory.term_id).html(subcategory.name);
        $subCategorySelect.append($option);
        $subCategorySelect.parent().show();
      });
    }
  });
}

$(document).ready(function() {
  filterData();
  var $country =  $("#country");
  var $state =  $("#state");
  countryFilter($country, $state);
});

$( "#filterJobs, #findJobs" ).click(function(event) {
  event.preventDefault();
  filterData();
});

$( "#sortBy, #recordsPerPage, #jobType, #industry, #gender, #country, #state" ).change(function(event) {
  event.preventDefault();
  filterData();
});


$('#resetJobs').click(function(){ 
    location.reload(true);
});

      

$(document).on("click","#pagination li a",function(event) {
  event.preventDefault();
  filterData( $(this).text() );
  $([document.documentElement, document.body]).animate({
    scrollTop: $('#jobData').offset().top - 200
  }, 500);
});


$(document).ready(function () {
  // Validate Form
  $.validator.addMethod("namefield", function (value, element) { return this.optional(element) || /^[a-z\'\s]+$/i.test(value); }, "Invalid Characters");
  $.validator.addMethod("phonefield", function (value, element) { return this.optional(element) || /^[0-9\+\s]+$/i.test(value); }, "Invalid phone number");
  $.validator.addMethod("msgfield", function (value, element) { return this.optional(element) || /^[a-z\0-9\,.'"!()+@\s]+$/i.test(value); }, "Invalid Characters");
  $.validator.addMethod('filesize', function (value, element, param) { return this.optional(element) || (element.files[0].size <= param)});
  $.validator.addMethod("accept", function (value, element, param) {return value.match(new RegExp("." + param + "$"));});
  $.validator.addMethod("validate_email", function(value, element) { if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) { return true; } else { return false;}
}, "Please enter a valid Email.");


  // Apply Job
  $("#applyJob").validate({
    rules: {
        firstName: {
            required: true,
            minlength: 2,
            maxlength: 25,
            namefield: true
        },
        lastName: {
            required: true,
            minlength: 1,
            maxlength: 25,
            namefield: true
        },
        email: {
            required: true,
            maxlength: 35,
            validate_email: true
        },
        phone: {
            required: true,
            phonefield: true,
            minlength: 10,
            maxlength: 25,
        },
        resume: {
          required: true,
          accept: "(docx?|doc|pdf)",
          filesize: 1048576
        }
    },
    messages: {
      firstName: "Enter your firstname",
      lastName: "Enter your lastname",
      resume: {
        accept: "Please choose docx, doc, pdf file.",
        filesize: "Maximum filesize allowed - 1MB"
      }
    },
    errorElement: "span",
    submitHandler: function (form) {
      $('#applyJobBtn').prop('disabled', true).text('Apply Job');
      applyJob($(form).serializeArray());
    }
  });

  // Email job
  $("#emailJob").validate({
      rules: {
          user_name: {
              required: true,
              minlength: 2,
              maxlength: 25,
              namefield: true
          },
          user_email: {
              required: true,
              maxlength: 35,
              validate_email: true
          }
      },
      errorElement: "span",
      submitHandler: function (form) {
        $('#emailJobbtn').prop('disabled', true).text('Email Job');
        mailJob();
      }
  });

});

var recaptcha1;
var recaptcha2;
var recaptcha1Resposnse;
var recaptcha2Resposnse;

var verifyCallback1 = function(response) {
  recaptcha1Resposnse = response;
};

var verifyCallback2 = function(response) {
  recaptcha2Resposnse = response;
};

var reCaptchaCallback = function() {
  //Render the recaptcha1 on the element with ID "recaptcha1"
  recaptcha1 = grecaptcha.render('recaptcha1', {
    'sitekey' : '6LcD4sQUAAAAAOzpw_28BC2GX78ym-A3QCTpk4Lu', //Replace this with your Site key
    'callback' : verifyCallback1,
    'theme' : 'light'
  });

  //Render the recaptcha2 on the element with ID "recaptcha2"
  recaptcha2 = grecaptcha.render('recaptcha2', {
    'sitekey' : '6LcFLPYUAAAAACdtDQfFLjFH_RxFHEUmVBoJhB7f', //Replace this with your Site key
    'callback' : verifyCallback2,
    'theme' : 'light'
  });
};

function applyJob(formdataSerialize) {

  var applyJob = document.getElementById("applyJob");
  var formdata = new FormData(applyJob );
  formdata.append("action", "ajaxApplyJob");   
  formdata.append("captcha", recaptcha1Resposnse);   

  $.ajax({
    url: ajaxurl,
    type: "POST",
    data: formdata,
    cache: false,
    processData: false, 
    contentType: false,  
    success:function(response){
      $('#applyJob').hide();
      if(response == 'SUCCESS') {
        $('#applyJobForm .confirmation-success').addClass('show');
        $('#applyJobForm .confirmation-danger').removeClass('show');
      } else {
        $('#applyJob').show();
        $('#applyJobForm .confirmation-success').removeClass('show');
        $('#applyJobForm .confirmation-danger').empty().append(response).addClass('show');
        $('#applyJobBtn').prop('disabled', false).text('Apply Job');
      }
    }
  });
}

// mailjob ajax
function mailJob() {

  var user_name = $('#user_name').val();
  var user_email = $('#user_email').val();
  var jobTitle = $('#jobTitle').val();
  var closingDate = $('#closingDate').val();
  var salary = $('#salary').val();
  var offeredSalary = $('#offeredSalary').val();
  var carrerLevel = $('#carrerLevel').val();
  var experience = $('#experience').val();
  var gender = $('#genderPreference').val();
  var industries = $('#industries').val();
  var qualifications = $('#qualifications').val();
  var industries = $('#industries').val();
  var jobDescription = $('#jobDescription').val();

  $.ajax({
    url: ajaxurl,
    type: "POST",
    cache: false,
    data: {
      action: 'ajaxEmailJob',
      user_name: user_name,
      user_email: user_email,
      jobTitle: jobTitle,
      closingDate: closingDate,
      salary : salary,
      offeredSalary : offeredSalary,
      carrerLevel : carrerLevel,
      experience : experience,
      gender : gender,
      industries : industries,
      qualifications : qualifications,
      jobDescription : jobDescription,
      captcha: recaptcha2Resposnse
    },
    success:function(response){
      $('#emailJob').hide();
      if(response == 'SUCCESS') {
        $('#sendEmailPoupup .confirmation-success').addClass('show');
        $('#sendEmailPoupup .confirmation-danger').removeClass('show');
      } else {
        $('#emailJob').show();
        $('#sendEmailPoupup .confirmation-success').removeClass('show');
        $('#sendEmailPoupup .confirmation-danger').empty().append(response).addClass('show');
        $('#emailJobbtn').prop('disabled', false).text('Send Email');
      }
    }
  });
}

$('input[name="datePosted"]').change(function(){
  event.preventDefault();
  filterData();
});