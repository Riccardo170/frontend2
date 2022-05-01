var url= 'http://localhost:8081/backrest/index.php';
var nexId = 10006;
var next;
var last;
var prev;
var first;
var response=null;
var id;

$(document).ready(function () {

  // url iniziale
  chiamataServer(url+"?page=0&size=20");
//elimina
  $("body").on("click", "#btn-delete", function () {
    $(this).parents("tr").fadeOut("fast");
    var td = $(this).parent("td");
    var id = td.data("id");
    console.log(id);
    $.ajax({
      url: url+'/?id='+id,// url + id dell'utente selezionato
      type: "delete", //si dice di vooler cancellare dal db
      success: function(data){
        

        displayTable(chiamataServer(url+"?page="+response['page']['number']+"&size=20"));}//e se ha successo(significa che è stata cancellata) si da la url all display table
  })
  });
  

//aggiungi
  $("body").on("click", "#btn-add", function () {
    var firstName = $('#firstName').val();
    console.log(firstName);
    var lastname = $('#lastname').val();
    console.log(lastname);

    var nuovo = {
      "id": nexId,
      "firstName": firstName,
      "lastName": lastname,
      "gender": "M",

    }
    $.ajax({
      type: "POST",
      url:  'http://localhost:8081/backrest/index.php/?nome='+nuovo.firstName+'&cognome='+nuovo.lastName,

      contentType: "application/json",
      

      success: function () {
          var last = response["_links"]["last"]["href"];
          console.log(last);
          chiamataServer(last);
      }
  });
    

    //chiusura dopo aggiungi
    var modal= $('#exampleModal');
    modal.modal("hide");


  });

  //modifica
  $("#confirm-modifica").click(function () {


    var data = {
      "id": id,
      "firstName": $("#nome-m").val(),
      "lastName": $("#cognome-m").val(),
      "gender": "M"
    }

    $.ajax({
      type: "PUT", //si dice di vooler aggiornare dal db
      url: 'http://localhost:8081/backrest/index.php/?id='+data.id+'&nome='+data.firstName+'&cognome='+data.lastName,// url + id dell'utente selezionato
        success: function(data){
          chiamataServer(response['_links']['self']['href']);

          
        }//e se ha successo(significa che è stata cancellata) si da la url all display table
    })
    var modal= $('#modalmodifica');
    modal.modal("hide");



    
  });


  $("body").on("click", "#btn-modifica", function () {


    $(this).parents("tr").fadeOut("fast");
    var td = $(this).parent("td");
    id = td.data("id");

    
    $.get('http://localhost:8081/backrest/index.php/?id=' + id, function(data) {

      $("#nome-m").val(data.firstName);
      $("#cognome-m").val(data.lastName);

    });

  });
  
});

function chiamataServer(link) {
  $.ajax({
    url: link,
    success: function( responseData ) {
      response=responseData;
      displayTable(response["_embedded"]["employees"]);
      console.log(response)
      //displayPagination(response["page"], response["_links"]);
      if(response["page"]["number"]!=response["page"]["totalPages"]-1){
        next = response['_links']['next']['href']
      }
      last=response['_links']['last']['href']
      prev=response['_links']['prev']['href']
      first=response['_links']['first']['href']
      
    },
    dataType: 'json'
  });

}


$('#next').click(function(){
  console.log(next);
  chiamataServer(next);
});

$('#last').click(function(){
  console.log(last);
  chiamataServer(last);
});

$('#prev').click(function(){
  console.log("prev:"+prev);
  chiamataServer(prev);
});

$('#first').click(function(){
  console.log(first);
  chiamataServer(first);
});

function displayTable(dati) {
  var r = '';
  $.each(dati, function (i, value) {
    r += '<tr>';
    r += '<td>' + value.id + '</td>';
    r += '<td>' + value.firstName + '</td>';
    r += '<td>' + value.lastName + '</td>';
    r += '<td data-id=' + value.id + '> <button type="button" class="btn btn-danger" id="btn-delete">Elimina</button>' + '</td>';
    r += '<td data-id=' + value.id + '> <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalmodifica" id="btn-modifica">Modifica</button>' + '</td>';
    r += '<tr>' + '</tr>';
  });
  $("tbody").html(r);
}
