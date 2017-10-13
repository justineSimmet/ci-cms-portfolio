
function alertMessage(state, message){
  var alertArea = $('#main-alert');
  var divAlert  ='<div class="alert alert-'+state+' alert-dismissible fade show" role="alert">'
                +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                +'<span aria-hidden="true">&times;</span>'
                +'</button>'
                + message
                +'</div>';
  alertArea.html(divAlert);
}






/*---------------------------------------------------------------------*/
/*----------------- GESTION DE LA TABLE DES VISITEURS -----------------*/
import 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.css';
import 'datatables.net-responsive-bs4';
// import 'datatables.net-scroller-bs4';
$('#visit-table').DataTable( {
  'pagingType': 'simple',
  'language': {
    'lengthMenu': 'Entrées par page _MENU_',
    'zeroRecords': 'Aucune entrée trouvée',
    'info': 'Page _PAGE_ sur _PAGES_',
    'infoEmpty': 'Aucune entrée disponible',
    'infoFiltered': '(sur _MAX_ entrées)',
    'search': 'rechercher :',
    'paginate': {
      'first': 'Première',
      'last': 'Dernière',
      'next': 'Suivante',
      'previous': 'Précédente',
    },
  },
});



/*---------------------------------------------------------------------*/
/*-------------- GESTION DES ITEMS DE LA CARD D'ACCUEIL ---------------*/

// Set custom event on bootstrap tab
$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
  var target = $(e.target).attr('href');
  var previous= $(e.relatedTarget).attr('href');
  $(previous).addClass('hide-dash');
  $(target).removeClass('hide-dash');
  if (target == '#dash-photo') {
    $('#dash-photo img').fadeIn(800);
  }
});

// Load quote of the day
var quoteUrl = 'http://quotes.stormconsultancy.co.uk/random.json';
$.getJSON(quoteUrl).done(function(data){
  var quote = data.quote,
    author = data.author,
    targetQuote = $('#dash-today .blockquote p'),
    targetAuthor = $('#dash-today .blockquote-footer');

  targetQuote.html(quote);
  targetAuthor.html('<cite title="'+author+'">'+author+'</cite>');  
});




/*---------------------------------------------------------------------*/
/*---------------------- GESTION DES GRAPHIQUES ----------------------*/

//Import de la librairie Chats.js
import 'chart.js/dist/Chart.bundle.js';

// Initiation du premier graph -> suivi des visiteurs du site
var visitChart = document.getElementById('visitChart').getContext('2d');

var visitsDate = visitsReport.date;
var visitsCount = visitsReport.count;
var anonymousCount = anonymousReport.count;
var sumVisits = visitsCount.reduce(function(a, b) {
  return a + b;
}, 0);

var visit = new Chart(visitChart, {
  type: 'line',
  data: {
    labels: visitsDate,
    datasets: [{
      label: 'Nombre de visiteurs anonymes par jours',
      data: anonymousCount,
      fill: false,
      backgroundColor: 'rgba(0,0,0,0)',
      borderColor: 'rgb(38,50,56)',
      lineTension: 0.5,
    },
    {
      label: 'Nombre de visiteurs par jours',
      data: visitsCount,
      fill: false,
      backgroundColor: 'rgba(0,0,0,0)',
      borderColor: 'rgb(255,214,0)',
      lineTension: 0.5,
    },
    ],
  },
  options: {
    responsive: true,
    title:{
      display:true,
      text:'Visiteurs journaliers. Total : '+sumVisits,
    },
  },
});

/*---------------------------------------------------------------------*/