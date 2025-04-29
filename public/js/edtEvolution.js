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


// https://www.w3schools.com/cssref/css_colors.php

  const projetInfoElements = document.querySelectorAll('[data-projet-info]');
  // console.log('ALL', projetInfoElements);
  const projetInfoObjects = Array.from(projetInfoElements).map(item => JSON.parse(item.dataset.projetInfo));

  const donateurInfoElements = document.querySelectorAll('[data-donateur-info]');
  // console.log('ALL', projetInfoElements);
  const donateurInfoObjects = Array.from(donateurInfoElements).map(item => JSON.parse(item.dataset.donateurInfo));
  
  const edtInfoElements = document.querySelectorAll('[data-edt-info]');
  // console.log('ALL', projetInfoElements);
  const edtInfoObjects = Array.from(edtInfoElements).map(item => JSON.parse(item.dataset.edtInfo));
    
  const devisInfoElements = document.querySelectorAll('[data-devis-info]');
  // console.log('ALL', projetInfoElements);
  const devisInfoObjects = Array.from(devisInfoElements).map(item => JSON.parse(item.dataset.devisInfo));
  console.log('INPUT devisInfoObjects', devisInfoObjects);

  const labels = months({count: 12});

  for (p=0; p < projetInfoObjects.length; p++) {

      projet_month_debit_dataset[projetInfoObjects[p].month-1] = projet_month_debit_dataset[projetInfoObjects[p].month-1] + 
                                                            Number(projetInfoObjects[p].debit)
    // console.log (projetInfoObjects[p].debit);
  }
  console.log ('projet_month_debit_dataset', projet_month_debit_dataset);


  for (d=0; d < donateurInfoObjects.length; d++) {

    donateur_month_credit_dataset[donateurInfoObjects[d].month-1] = donateur_month_credit_dataset[donateurInfoObjects[d].month-1] + 
                                                          Number(donateurInfoObjects[d].credit)
  // console.log (projetInfoObjects[p].debit);
   }

  console.log ('donateur_month_credit_dataset', donateur_month_credit_dataset);


  for (e=0; e < edtInfoObjects.length; e++) {
    if (edtInfoObjects[e].year == 2024) {
      edtInfoObjects[e].year = 2025;
      edtInfoObjects[e].month = 1;
    }
    edt_month_credit_dataset[edtInfoObjects[e].month-1] = edt_month_credit_dataset[edtInfoObjects[e].month-1] + 
                                                          Number(edtInfoObjects[e].credit)
    edt_month_debit_dataset[edtInfoObjects[e].month-1] = edt_month_debit_dataset[edtInfoObjects[e].month-1] + 
                                                          Number(edtInfoObjects[e].debit)
  // console.log (projetInfoObjects[p].debit);
  }

  console.log ('edt_month_credit_dataset', edt_month_credit_dataset);
  console.log ('edt_month_debit_dataset', edt_month_debit_dataset);

  for (s=0; s < solde_month_dataset.length; s++){
    solde_month_dataset[s] = solde_month_dataset[s] + edt_month_credit_dataset[s] + donateur_month_credit_dataset[s]
                                                    - edt_month_debit_dataset[s] - projet_month_debit_dataset[s];
    if (s > 0 ) {solde_month_dataset[s] = solde_month_dataset[s] + solde_month_dataset[s-1]}
  }
  console.log ('devisInfoObjects', devisInfoObjects);

  for (d=0; d < devisInfoObjects.length; d++){
    if (devisInfoObjects[d].year == 2024) {
      devisInfoObjects[d].year = 2025;
      devisInfoObjects[d].month = 1;
    }
    devis_month_dataset[devisInfoObjects[d].month-1] = devis_month_dataset[devisInfoObjects[d].month-1] 
                                                     + Number(devisInfoObjects[d].devis) ;
  }
  console.log('2025 devisInfoObjects', devisInfoObjects);
  console.log ('2025 devis_month_dataset', devis_month_dataset);

  for (d=1; d < devis_month_dataset.length; d++)
    {devis_month_dataset[d] = devis_month_dataset[d] - projet_month_debit_dataset[d] + devis_month_dataset[d-1]}
  console.log ('end devis_month_dataset', devis_month_dataset);


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
      backgroundColor: [
        CHART_COLORS.edt_credit,
      ],
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