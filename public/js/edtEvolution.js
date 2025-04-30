import { CHART_COLORS } from "./edtColor.js";
import { Bank } from "./edtBank.js";
import { Project } from "./edtProject.js";
import { Category } from "./edtCategory.js";
import { months } from "./edtHelpers.js";

$(document).ready(function () {

  var p, d, e, s;
  var projet_month_debit_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var donateur_month_credit_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var edt_month_credit_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var edt_month_debit_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var solde_month_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var devis_month_dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  var debug = 1;

  const yearFilter = document.getElementById("yearFilter").innerHTML;
  console.log('yearFilter', yearFilter);

// https://www.w3schools.com/cssref/css_colors.php

  const projetInfoElements = document.querySelectorAll('[data-projet-info]');
  // console.log('projetInfoElements', projetInfoElements);
  const projetInfoObjects = Array.from(projetInfoElements).map(item => JSON.parse(item.dataset.projetInfo));
  if (debug == 1) console.log('INPUT projetInfoObjects', projetInfoObjects);

  const donateurInfoElements = document.querySelectorAll('[data-donateur-info]');
  // console.log('ALL', projetInfoElements);
  const donateurInfoObjects = Array.from(donateurInfoElements).map(item => JSON.parse(item.dataset.donateurInfo));
  if (debug == 1) console.log('INPUT donateurInfoObjects', donateurInfoObjects);

  const edtInfoElements = document.querySelectorAll('[data-edt-info]');
  // console.log('ALL', edtInfoElements);
  const edtInfoObjects = Array.from(edtInfoElements).map(item => JSON.parse(item.dataset.edtInfo));
  if (debug == 1) console.log('INPUT edtInfoObjects', edtInfoObjects);
  
  const devisInfoElements = document.querySelectorAll('[data-devis-info]');
  // console.log('ALL', projetInfoElements);
  const devisInfoObjects = Array.from(devisInfoElements).map(item => JSON.parse(item.dataset.devisInfo));
  if (debug == 1)  console.log('INPUT devisInfoObjects', devisInfoObjects);

  const labels = months({count: 12});

  for (p=0; p < projetInfoObjects.length; p++) {

      projet_month_debit_dataset[projetInfoObjects[p].month-1] = projet_month_debit_dataset[projetInfoObjects[p].month-1] + 
                                                            Number(projetInfoObjects[p].debit)
  }
  if (debug == 1)  console.log ('projet_month_debit_dataset', projet_month_debit_dataset);


  for (d=0; d < donateurInfoObjects.length; d++) {

    donateur_month_credit_dataset[donateurInfoObjects[d].month-1] = donateur_month_credit_dataset[donateurInfoObjects[d].month-1] + 
                                                          Number(donateurInfoObjects[d].credit)
   }

   if (debug == 1)  console.log ('donateur_month_credit_dataset', donateur_month_credit_dataset);

  for (e=0; e < edtInfoObjects.length; e++) {
    if (edtInfoObjects[e].year == yearFilter-1) {
      edtInfoObjects[e].year = yearFilter;
      edtInfoObjects[e].month = 1;
    }
    if (edtInfoObjects[e].year == yearFilter+1) {
      edtInfoObjects[e].year = yearFilter;
      edtInfoObjects[e].month = 12;
    }

    edt_month_credit_dataset[edtInfoObjects[e].month-1] = edt_month_credit_dataset[edtInfoObjects[e].month-1] + 
                                                          Number(edtInfoObjects[e].credit)
    edt_month_debit_dataset[edtInfoObjects[e].month-1] = edt_month_debit_dataset[edtInfoObjects[e].month-1] + 
                                                          Number(edtInfoObjects[e].debit)
  }

  if (debug == 1)  console.log ('edt_month_credit_dataset', edt_month_credit_dataset);
  if (debug == 1)  console.log ('edt_month_debit_dataset', edt_month_debit_dataset);

  for (s=0; s < solde_month_dataset.length; s++){
    solde_month_dataset[s] = solde_month_dataset[s] + edt_month_credit_dataset[s] + donateur_month_credit_dataset[s]
                                                    - edt_month_debit_dataset[s] - projet_month_debit_dataset[s];
    if (s > 0 ) {solde_month_dataset[s] = solde_month_dataset[s] + solde_month_dataset[s-1]}
  }
  if (debug == 1)console.log ('devisInfoObjects', devisInfoObjects);

  for (d=0; d < devisInfoObjects.length; d++){
    if (devisInfoObjects[d].year == yearFilter-1) {
      devisInfoObjects[d].year = yearFilter;
      devisInfoObjects[d].month = 1;
    }    
    if (devisInfoObjects[d].year == yearFilter+1) {
      devisInfoObjects[d].year = yearFilter;
      devisInfoObjects[d].month = 12;
    }
    devis_month_dataset[devisInfoObjects[d].month-1] = devis_month_dataset[devisInfoObjects[d].month-1] 
                                                     + Number(devisInfoObjects[d].devis) ;
  }
  if (debug == 1) console.log('devisInfoObjects', devisInfoObjects);
  if (debug == 1) console.log ('2devis_month_dataset', devis_month_dataset);

  devis_month_dataset[0] = devis_month_dataset[0] - projet_month_debit_dataset[0] 
  for (d=1; d < devis_month_dataset.length; d++)
    {devis_month_dataset[d] = devis_month_dataset[d] - projet_month_debit_dataset[d] + devis_month_dataset[d-1]}
  if (debug == 1) console.log ('end devis_month_dataset', devis_month_dataset);


  // var toto = 0;
  // if (document.getElementById('evolutionTable')) {
  //   document.getElementById('evolutionTable').innerHTML = "<tr>"
  //   document.getElementById('evolutionTable').innerHTML = "<tr>"
  //   for (d=0; d < projet_month_debit_dataset.length; d++) {
  //     toto = toto + Number(projet_month_debit_dataset[d]);
  //     console.log ( toto)
  //     document.getElementById('evolutionTable').innerHTML = "<td>" + toto + "</td>"
  //   }
  //   document.getElementById('evolutionTable').innerHTML = "</tr>"
  // }
  // ************************************
  // DATASET EXAMPLE
  // ************************************

  const dataAll = {
    labels: [
      'CREDIT',
      'DEBIT',
      'BILAN'
    ],
    datasets: [{
      // label: 'My First Dataset',
      data: ['10', '-20', '5'],
      backgroundColor: [
        CHART_COLORS.credit,
        CHART_COLORS.debit,
        CHART_COLORS.balance,
      ],
      hoverOffset: 4
    }]
  };

  
  // ************************************
  // DATASET ALL YEAR
  // ************************************

  const dataAllYear = {
    labels: labels,

    datasets: [
      {
      label: 'projets',
      data: projet_month_debit_dataset,
      backgroundColor: [
        CHART_COLORS.projets,
      ],
      stack: 'Stack 1',
      order: 2,
    },
    {
      label: 'edt_debit',
      data: edt_month_debit_dataset,
      backgroundColor: [
        CHART_COLORS.edt_debit,
      ],
      stack: 'Stack 1',
      order: 2,
    },
    {
      label: 'dons',
      data: donateur_month_credit_dataset,
      backgroundColor: [
        CHART_COLORS.dons,
      ],
      order: 2,
      stack: 'Stack 2',
    },
    {
      label: 'edt_credit',
      data: edt_month_credit_dataset,
      backgroundColor: CHART_COLORS.edt_credit,
      // backgroundColor: transparentize(CHART_COLORS.edt_credit, 0.5),
      order: 2,
      stack: 'Stack 2',
    },
    {
      label: 'solde',
      data: solde_month_dataset,
      backgroundColor: CHART_COLORS.solde,
      borderColor: CHART_COLORS.solde,
      order: 1,
      type: 'line',
      fill: false,
    },
    {
      label: 'devis',
      data: devis_month_dataset,
      backgroundColor: CHART_COLORS.devis,
      borderColor: CHART_COLORS.devis,
      order: 1,
      type: 'line',
      fill: false,
    }

  ]

  };

  // ************************************
  // ALL 
  // ************************************

  if (document.getElementById('chartAll')) {
    new Chart(
      document.getElementById('chartAll'),
      {
        type: 'bar',
        data:  dataAll,
        options: {
          responsive: true,
          plugins: {

            legend: {
              display: false,
              position: 'bottom',
              labels: {
                color: 'black',
              }
            }
          }
        }
      }
    );
  }


  // ************************************
  // ALL YEAR CONFIG
  // ************************************

  if (document.getElementById('chartAllYear')) {
    new Chart(
      document.getElementById('chartAllYear'),
      {
        type: 'bar',
        data:  dataAllYear,
        options: {
          responsive: true,
          interaction: {
            intersect: false,
          },
          // scales: {
          //   x: {
          //     stacked: true,
          //   },
          //   y: {
          //     stacked: true
          //   }
          // },
          plugins: {

            legend: {
              display: true,
              position: 'top',
              labels: {
                color: 'black',
              }
            }
          }
        }
      }
    );
  }

});