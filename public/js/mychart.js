import { CHART_COLORS } from "./myColor.js";
import { Bank } from "./bank.js";
import { Project } from "./project.js";
import { Category } from "./category.js";

$(document).ready(function () {

// https://www.w3schools.com/cssref/css_colors.php

  var BANK = [];
  var PROJECT = [];
  var CATEGORY = [];
  var EXPENSES_TOTAL = 0;
  var INCOMES_TOTAL = 0;
  var SAVINGS_OUT_TOTAL = 0;
  var SAVINGS_IN_TOTAL = 0;
  var SAVINGS = 0;
  var PROJECT_EXPENSES_TOTAL = [];
  var PROJECT_INCOMES_TOTAL = [];
  var p, b, i, c, e;

  const affectationFilter = document.getElementById("affectationFilter").innerHTML;
  console.log('affectationFilter', affectationFilter);
  var affectationFilterIndex = 0;


  const bankInfoElements = document.querySelectorAll('[data-bank-id]');
  // console.log('ALL',entryInfoElements);
  const bankInfoObjects = Array.from(bankInfoElements).map(item => JSON.parse(item.dataset.bankId));
  console.log('BANKS', bankInfoObjects, 'LENGTH ', bankInfoObjects.length);

  const entryInfoElements = document.querySelectorAll('[data-table-info]');
  // console.log('ALL',entryInfoElements);
  const entryInfoObjects = Array.from(entryInfoElements).map(item => JSON.parse(item.dataset.tableInfo));
  console.log('KONTO ', entryInfoObjects, 'LENGTH ', entryInfoObjects.length);

  const projectElements = document.querySelectorAll('[data-project-id]');
  // console.log('BANKS', bankElements);
  const projectInfoObjects = Array.from(projectElements).map(item => JSON.parse(item.dataset.projectId));
  console.log('PROJECTS',projectInfoObjects, 'LENGTH ', projectInfoObjects.length);
  for (p=0; p < projectInfoObjects.length; p++) {
    if (projectInfoObjects[p].name == affectationFilter) {
      affectationFilterIndex = p;
    }
  }

  const operationElements = document.querySelectorAll('[data-operation-id]');
  // console.log('GROUPS', groupElements);
  const operationInfoObjects = Array.from(operationElements).map(item => JSON.parse(item.dataset.operationId));
  console.log('OPERATIONS',operationInfoObjects, 'LENGTH ', operationInfoObjects.length);

  const categoryElements = document.querySelectorAll('[data-category-id]');
  // console.log('GROUPS', groupElements);
  const categoryInfoObjects = Array.from(categoryElements).map(item => JSON.parse(item.dataset.categoryId));
  console.log('CATEGORIES',categoryInfoObjects, 'LENGTH ', categoryInfoObjects.length);


  const getTable = function (filter, name) {
    var j=0;
    const localTable = [];
    for (i=0; i<entryInfoObjects.length; i++) {
      if (filter == 'ALL') {
          localTable[j] = Object.assign({}, entryInfoObjects[i]);
          j++;
      }
      if (filter == 'BANK') {
        if (entryInfoObjects[i].bank == name) {
          localTable[j] = Object.assign({}, entryInfoObjects[i]);
          j++;
        }
      }
      if (filter == 'PROJECT') {
        if (entryInfoObjects[i].project == name) {
          localTable[j] = Object.assign({}, entryInfoObjects[i]);
          j++;
        }
      }
      if (filter == 'OPERATION') {
        if (entryInfoObjects[i].operation == name) {
          localTable[j] = Object.assign({}, entryInfoObjects[i]);
          j++;
        }
      }
      if (filter == 'CATEGORY') {
        if (entryInfoObjects[i].category == name) {
          localTable[j] = Object.assign({}, entryInfoObjects[i]);
          j++;
        }
      }
    }
    // console.log('getBankTable',entryInfoObjects.length, bank, localTable);
    return localTable;
  }

  // ******************************
  // BANK TABLE
  // ******************************

  for (b=0; b < bankInfoObjects.length; b++) {
    BANK[b] = new Bank(bankInfoObjects[b].name, 
                        b, 
                        getTable('BANK', bankInfoObjects[b].name)
                      );
    BANK[b].setIncExp();
    for (p=0; p < projectInfoObjects.length; p++) {
      BANK[b].setProjects(projectInfoObjects[p].name, p);
    }
    // console.log('BANK',BANK[b].getName(), BANK[b].getColor(), BANK[b]);
  }


  // ******************************
  // PROJECT TABLE
  // ******************************

  var index = 0;
  for (p=0; p < projectInfoObjects.length; p++) {
    if (index == 7) {index=0;}
    PROJECT[p] = new Project(projectInfoObjects[p].name, 
                          index, 
                          getTable('PROJECT', projectInfoObjects[p].name)
                        );
    PROJECT[p].setIncExp();
    index++;
    for (c=0; c < categoryInfoObjects.length; c++) {
      PROJECT[p].setCategories(categoryInfoObjects[c].name, c);
    }
    // console.log('PROJECT',PROJECT[p].getName(), PROJECT[p]);
  }

  // ******************************
  // CATEGORY TABLE
  // ******************************
  index = 0;
  for (c=0; c < categoryInfoObjects.length; c++) {
    if (index == 7) {index=0;}
    CATEGORY[c] = new Category(categoryInfoObjects[c].name, 
                                index, 
                                getTable('CATEGORY', categoryInfoObjects[c].name)
                              );
    // console.log('CATEGORY',index, CATEGORY[c].getName(), CATEGORY[g]);
    index++;
  }

  // ******************************
  // EXPENSES / INCOMES
  // ******************************

  for (b=0; b < bankInfoObjects.length; b++) {
    EXPENSES_TOTAL = EXPENSES_TOTAL + BANK[b].getExpenses();
    INCOMES_TOTAL = INCOMES_TOTAL + BANK[b].getIncomes();
    SAVINGS_OUT_TOTAL = SAVINGS_OUT_TOTAL + BANK[b].getSavingsOut();
    SAVINGS_IN_TOTAL = SAVINGS_IN_TOTAL + BANK[b].getSavingsIn();
  }
  SAVINGS = (SAVINGS_OUT_TOTAL*-1) - SAVINGS_IN_TOTAL;
  // console.log('EXPENSES_TOTAL',EXPENSES_TOTAL, 'INCOMES_TOTAL',INCOMES_TOTAL);

  for (p=0; p < projectInfoObjects.length; p++) {
    PROJECT_EXPENSES_TOTAL[p] = 0;
    PROJECT_INCOMES_TOTAL[p] = 0;
    PROJECT_EXPENSES_TOTAL[p] = PROJECT_EXPENSES_TOTAL[p] + PROJECT[p].getExpenses(p);
    PROJECT_INCOMES_TOTAL[p] = PROJECT_INCOMES_TOTAL[p] + PROJECT[p].getIncomes(p);
  };
  // console.log('Group Expenses', GROUP_EXPENSES_TOTAL );

  // ////////////////////////////////
  //
  // CHART DATA
  //
  // ////////////////////////////////
    
  // ************************************
  // ALL ACCOUNTS INCOMES EXPENSES
  // ************************************

  const bank_labels = [];
  const bank_colors = [];
  for (b=0; b < bankInfoObjects.length; b++){
    bank_labels[b] = BANK[b].getName();
    bank_colors[b] = BANK[b].getColor();
  }

  // const dataAllAccountsIncExp = {
  //   labels: bank_labels,
  //   datasets: [
  //     {

  //       label: 'INCOME',
  //       backgroundColor: CHART_COLORS.lightseagreen,
  //       data: [
  //         BANK[0].getIncomes(), 
  //         BANK[1].getIncomes(), 
  //         BANK[2].getIncomes(), 
  //       ],
  //   }, {
  //       label: 'EXPENSES',
  //       backgroundColor: CHART_COLORS.salmon,
  //       data: [
  //         BANK[0].getExpenses()*-1, 
  //         BANK[1].getExpenses()*-1, 
  //         BANK[2].getExpenses()*-1, 
  //       ],
  //   },
    
  // ]};

  // ************************************
  // ALL BANKS INCOMES EXPENSES
  // ************************************

  const dataAllBanksIncExpSav = {
    labels: [
      'CREDIT',
      'DEBIT',
    ],
    datasets: [{
      // label: 'My First Dataset',
      data: [INCOMES_TOTAL, EXPENSES_TOTAL],
      backgroundColor: [
        CHART_COLORS.credit,
        CHART_COLORS.debit,
      ],
      hoverOffset: 4
    }]
  };

  // ************************************
  // ALL PROJECTS ALL BANKS EXPENSES
  // ************************************

  const project_exp_labels = [];
  const project_exp_colors = [];
  const project_exp = [];
  i=0;
  for (p=0; p < PROJECT.length; p++) {
    if (PROJECT_EXPENSES_TOTAL[p] > 0 && PROJECT[p].getName() != 'AUTRE'  ) {
      project_exp_labels[i] = PROJECT[p].getName();
      project_exp_colors[i] = PROJECT[p].getColor();
      project_exp[i] = PROJECT[p].getExpenses();
      i++;
    }
  }
  // console.log('project_labels', project_labels)
  // console.log('project_labels', project_labels)
  // console.log('GROUP_EXPENSES_TOTAL', GROUP_EXPENSES_TOTAL)
  const dataAllProjectsAllBanksExp = {
    labels: project_exp_labels,
    datasets: [{
      // label: 'My First Dataset',
      // data: [10,20,30,50,40,10,20,30,50,40, 25, 64],
      data: project_exp,
      backgroundColor: project_exp_colors,
      hoverOffset: 4
    }]
  };

  // ************************************
  // ALL PROJECTS ALL BANKS INCOMES
  // ************************************

  const project_inc_labels = [];
  const project_inc_colors = [];
  const project_inc = [];
  i=0;
  for (p=0; p < PROJECT.length; p++) {
    if (PROJECT_INCOMES_TOTAL[p] > 0 && PROJECT[p].getName() != 'AUTRE') {
      project_inc_labels[i] = PROJECT[p].getName();
      project_inc_colors[i] = PROJECT[p].getColor();
      project_inc[i] = PROJECT[p].getIncomes();
      i++;
    }
  }
  // console.log('project_labels', project_inc_labels)
  // console.log('project_inc', project_inc)
  // console.log('GROUP_EXPENSES_TOTAL', GROUP_EXPENSES_TOTAL)
  const dataAllProjectsAllBanksInc = {
    labels: project_inc_labels,
    datasets: [{
      // label: 'My First Dataset',
      // data: [10,20,30,50,40,10,20,30,50,40, 25, 64],
      data: project_inc,
      backgroundColor: project_inc_colors,
      hoverOffset: 4
    }]
  };



  // // ************************************
  // // BANK INCOMES EXPENSES SAVINGS
  // // ************************************

  // const dataBankIncExpSav = [];
  // for (b=0; b < bankInfoObjects.length; b++) {

  //   EXPENSES_TOTAL = BANK[b].getExpenses();
  //   INCOMES_TOTAL = BANK[b].getIncomes();
  //   SAVINGS_OUT_TOTAL = BANK[b].getSavingsOut();
  //   SAVINGS_IN_TOTAL = BANK[b].getSavingsIn();
  //   SAVINGS = (SAVINGS_OUT_TOTAL*-1) - SAVINGS_IN_TOTAL;

  //   dataBankIncExpSav[b] = {
  //     labels: [
  //       'INCOMES',
  //       'EXPENSES',
  //       'SAVINGS',
  //     ],
  //     datasets: [{
  //       // label: 'My First Dataset',
  //       data: [INCOMES_TOTAL, EXPENSES_TOTAL, SAVINGS],
  //       backgroundColor: [
  //         CHART_COLORS.lightseagreen,
  //         CHART_COLORS.salmon,
  //         CHART_COLORS.fuchsia,
  //       ],
  //       hoverOffset: 4
  //     }]
  //   };
  // }

  // // ************************************
  // // ALL GROUPS PER BANK EXPENSES
  // // ************************************

  // var dataAllGroupsPerBankExp = [];
  // for (b=0; b < bankInfoObjects.length; b++) {
  //   var bankGroupExpenses_total = [];
  //   var bankGroupIncomes_total = [];
  //   for (g=0; g < groupInfoObjects.length; g++) {
  //     bankGroupExpenses_total[g] = 0;
  //     bankGroupIncomes_total[g] = 0;
  //     bankGroupExpenses_total[g] = BANK[b].getGroupExpenses(g);
  //     bankGroupIncomes_total[g] = BANK[b].getGroupIncomes(g);
  //   };
  //   console.log('bankGroupExpenses_total', bankGroupExpenses_total)

  //   dataAllGroupsPerBankExp[b] = {
  //     labels: group_labels,
  //     datasets: [{
  //       // label: 'My First Dataset',
  //       // data: [10,20,30,50,40,10,20,30,50,40, 25, 64],
  //       data: bankGroupExpenses_total,
  //       backgroundColor: group_colors,
  //       hoverOffset: 4
  //     }]
  //   };
  // }

  // ************************************
  // ONE GROUP ALL BANKS EXPENSES
  // ************************************


  const dataOneProjectAllBanksExp = {
    labels: bank_labels,
    datasets: [{
      // label: 'My First Dataset',
      data: [ BANK[0].getProjectExpenses(affectationFilterIndex),
            ],
      backgroundColor: bank_colors,
      hoverOffset: 4
    }]
  };

  // ************************************
  // ONE GROUP ALL BANKS INCOMES
  // ************************************


  const dataOneProjectAllBanksInc = {
    labels: bank_labels,
    datasets: [{
      // label: 'My First Dataset',
      data: [ BANK[0].getProjectIncomes(affectationFilterIndex),
            ],
      backgroundColor: bank_colors,
      hoverOffset: 4
    }]
  };
  // **************************************
  // ALL CATS ONE GROUP ALL BANKS EXPENSES
  // **************************************

  const categories_expenses = [];
  const categories_exp_labels = [];
  const categories_exp_colors = [];
    for (p=0; p < PROJECT.length; p++) {
      // console.log('catchart', PROJECT[p].getName(), affectationFilter );
      if (PROJECT[p].getName() == affectationFilter) {
      var i=0;
      for (c=0; c < CATEGORY.length; c++) {
        if (PROJECT[p].getCatExpenses(c) != 0) {
          categories_exp_labels[i] = CATEGORY[c].getName();
          categories_exp_colors[i] = CATEGORY[c].getColor();
          categories_expenses[i] = PROJECT[p].getCatExpenses(c)
          i++;
        }
      }
    }
  }
  // console.log('catchart', categories_labels, categories_expenses );


  const dataAllCatsOneProjectAllBanksExp = {
      labels: categories_exp_labels,
      datasets: [{
        // label: 'My First Dataset',
        // data: [10,20,30,50,40,10,20,30,50,40, 25, 64],
        data: categories_expenses,
        backgroundColor: categories_exp_colors,
        hoverOffset: 4
      }]
    };

  // **************************************
  // ALL CATS ONE GROUP ALL BANKS INCOMES
  // **************************************
  const categories_incomes = [];
  const categories_inc_labels = [];
  const categories_inc_colors = [];
  for (p=0; p < PROJECT.length; p++) {
    // console.log('catchart', PROJECT[p].getName(), affectationFilter );
    if (PROJECT[p].getName() == affectationFilter) {
    var i=0;
    for (c=0; c < CATEGORY.length; c++) {
      if (PROJECT[p].getCatIncomes(c) != 0) {
        categories_inc_labels[i] = CATEGORY[c].getName();
        categories_inc_colors[i] = CATEGORY[c].getColor();
        categories_incomes[i] = PROJECT[p].getCatIncomes(c)
        i++;
      }
    }
  }
}    

const dataAllCatsOneProjectAllBanksInc = {
      labels: categories_inc_labels,
      datasets: [{
        // label: 'My First Dataset',
        // data: [10,20,30,50,40,10,20,30,50,40, 25, 64],
        data: categories_incomes,
        backgroundColor: categories_inc_colors,
        hoverOffset: 4
      }]
    };

  //   const dataAllCatsOneGroupOneBankExp = [];
  //   for (b=0; b < bankInfoObjects.length; b++) {
  //     const bank_categories_expenses = [];
  //     const bank_categories_labels = [];
  //     const bank_categories_colors = [];
  //     const localExpenses = [];
  //     i=0;
  //     for (c=0; c < CATEGORY.length; c++) {
  //       localExpenses[c] = 0;
  //       for (e=0; e < CATEGORY[c].table.length; e++) {
  //         if ((CATEGORY[c].table[e].bank == BANK[b].getName()) && 
  //             (CATEGORY[c].table[e].group == groupFilter)) {

  //             if ((Number(CATEGORY[c].table[e].amount) < 0) ) {
  //               localExpenses[c] = localExpenses[c] + Number(CATEGORY[c].table[e].amount*100);
  //             }
  //         }
  //       }
  //       if (localExpenses[c]/100 <0) { 
  //         bank_categories_expenses[i] = localExpenses[c]/100;
  //         bank_categories_colors[i] = CATEGORY[c].getColor();
  //         bank_categories_labels[i] = CATEGORY[c].getName();
  //         i++
  //       }
  //     }
        
  //     dataAllCatsOneGroupOneBankExp[b] = {
  //       labels: bank_categories_labels,
  //       datasets: [{
  //         // label: 'My First Dataset',
  //         // data: [10,20,30,50,40,10,20,30,50,40, 25, 64],
  //         data: bank_categories_expenses,
  //         backgroundColor: bank_categories_colors,
  //         hoverOffset: 4
  //       }]
  //     };
  //   }

  // // console.log('catchart', categories_labels, categories_expenses );

  // ////////////////////////////////////
  //
  // CHARTS
  //
  // ////////////////////////////////////

  // // ************************************
  // // ALL ACCOUNTS INCOMES EXPENSES
  // // ************************************

  // if (document.getElementById('chartAllAccountsIncExp')) {
  //   new Chart(
  //     document.getElementById('chartAllAccountsIncExp'),
  //     {
  //       type: 'bar',
  //       data:  dataAllAccountsIncExp,
  //       options: {
  //         plugins: {
  //           title: {
  //             display: true,
  //             text: 'COMPTES',
  //             color: 'white'
  //           },
  //           legend: {
  //             display: false,
  //             position: 'top',
  //             labels: {
  //               color: 'white',
  //             }
  //           }
  //         }
  //       }
  //     }
  //   );
  // }

  // ************************************
  // ALL BANKS INCOMES EXPENSES SAVINGS
  // ************************************

  if (document.getElementById('chartAllBanksIncExpSav')) {
    new Chart(
      document.getElementById('chartAllBanksIncExpSav'),
      {
        type: 'bar',
        data:  dataAllBanksIncExpSav,
        options: {
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


  // // ************************************
  // // ALL PROJECTS ALL BANKS EXPENSES
  // // ************************************

  if (document.getElementById('chartAllProjectsAllBanksExp')) {
    const chartAllProjectsAllBanksExp =  new Chart(
      document.getElementById('chartAllProjectsAllBanksExp'),
      {
        type: 'bar',
        data:  dataAllProjectsAllBanksExp,
        options: {
          responsive: true,
          // indexAxis: 'y',
          scales: {
            y: {
              ticks: {
                // forces step size to be 50 units
                stepSize: 1000,
                autoSkip: false,
              }
            },
          //   // grid: {
          //   //   tickWidth: 100

          //   // }
          },
      
          plugins: {
            title: {
              display: true,
              text: 'DEPENSES',
              color: 'black'
            },
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
    // chartAllProjectsAllBanksExp.toggleDataVisibility(2);    
    // chartAllProjectsAllBanksExp.toggleDataVisibility(9);    
    // chartAllProjectsAllBanksExp.update();
    }

  // // ************************************
  // // ALL PROJECTS ALL BANKS INCOMES
  // // ************************************

  if (document.getElementById('chartAllProjectsAllBanksInc')) {
    const chartAllProjectsAllBanksExp =  new Chart(
      document.getElementById('chartAllProjectsAllBanksInc'),
      {
        type: 'pie',
        data:  dataAllProjectsAllBanksInc,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'CREDIT',
              color: 'black'
            },
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                color: 'black',
              }
            }
          }
        }
      }
    );
    // chartAllProjectsAllBanksExp.toggleDataVisibility(2);    
    // chartAllProjectsAllBanksExp.toggleDataVisibility(9);    
    // chartAllProjectsAllBanksExp.update();
    }


  // // ************************************
  // // BANK INCOMES EXPENSES SAVINGS
  // // ************************************

  // var id;
  // for (b=0; b < bankInfoObjects.length; b++) {
  //   id = 'chartBankIncExpSav-'.concat(BANK[b].getName());
  //   // console.log('ID', id);
  //   if (document.getElementById(id)) {
  //     new Chart(
  //       document.getElementById(id),
  //       {
  //         type: 'doughnut',
  //         data:  dataBankIncExpSav[b],
  //         options: {
  //           plugins: {
  //             title: {
  //               display: false,
  //               text: BANK[b].getName(),
  //               color: 'white'
  //             },
  //               legend: {
  //               display: true,
  //               position: 'bottom',
  //               labels: {
  //                 color: 'white',
  //               }
  //             }
  //           }
  //         }
  //       }
  //     );
  //   }
  // }

  // // ************************************
  // // ALL GROUPS PER BANK
  // // ************************************

  // const chartAllGroupsPerBankExp = [];
  //   for (b=0; b < bankInfoObjects.length; b++) {
  //     id = 'chartAllGroupsPerBankExp-'.concat(BANK[b].getName());
  //     // console.log('ID', id);
  //     if (document.getElementById(id)) {
  //       chartAllGroupsPerBankExp[b] = new Chart(
  //         document.getElementById(id),
  //         {
  //           type: 'pie',
  //           data:  dataAllGroupsPerBankExp[b],
  //           options: {
  //             responsive: true,
  //             plugins: {
  //               title: {
  //                 display: false,
  //                 text: 'EXPENSES',
  //                 color: 'white'
  //               },
  //               legend: {
  //                 display: true,
  //                 position: 'bottom',
  //                 labels: {
  //                   color: 'white',
  //                 }
  //               }
  //             }
  //           }
  //         }
  //       );
  //       chartAllGroupsPerBankExp[b].toggleDataVisibility(2);    
  //       chartAllGroupsPerBankExp[b].toggleDataVisibility(9);    
  //       chartAllGroupsPerBankExp[b].update();
  //       }
  //   }

  // ************************************
  // ONE GROUP ALL BANKS
  // ************************************

    if (document.getElementById('chartOneProjectAllBanksExp')) {
      new Chart(
        document.getElementById('chartOneProjectAllBanksExp'),
        {
          type: 'doughnut',
          data:  dataOneProjectAllBanksExp,
          options: {
            plugins: {
              legend: {
                display: true,
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
  // ALL CATS ONE GROUP ALL BANKS EXPENSES
  // ************************************

  if (document.getElementById('chartAllCatsOneProjectAllBanksExp')) {
    new Chart(
      document.getElementById('chartAllCatsOneProjectAllBanksExp'),
      {
        type: 'pie',
        data:  dataAllCatsOneProjectAllBanksExp,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'DEPENSES',
              color: 'black'
            },
            legend: {
              display: true,
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
  // ALL CATS ONE GROUP ALL BANKS EXPENSES
  // ************************************

  if (document.getElementById('chartAllCatsOneProjectAllBanksInc')) {
    new Chart(
      document.getElementById('chartAllCatsOneProjectAllBanksInc'),
      {
        type: 'pie',
        data:  dataAllCatsOneProjectAllBanksInc,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'CREDIT',
              color: 'black'
            },
            legend: {
              display: true,
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

    // // ************************************
  // // ALL CATS ONE GROUP ONE BANK EXPENSES
  // // ************************************

  // var chartAllCatsOneGroupOneBankExp = []
  // for (b=0; b < bankInfoObjects.length; b++) {
  //   id = 'chartAllCatsOneGroupOneBankExp-'.concat(BANK[b].getName());
  //   // console.log('ID', id);
  //   if (document.getElementById(id)) {
  //     chartAllCatsOneGroupOneBankExp[b] = new Chart(
  //       document.getElementById(id),
  //       {
  //         type: 'pie',
  //         data:  dataAllCatsOneGroupOneBankExp[b],
  //         options: {
  //           responsive: true,
  //           plugins: {
  //             title: {
  //               display: false,
  //               text: 'EXPENSES',
  //               color: 'white'
  //             },
  //             legend: {
  //               display: true,
  //               position: 'bottom',
  //               labels: {
  //                 color: 'white',
  //               }
  //             }
  //           }
  //         }
  //       }
  //     );
  //   }
  // }
  
  

});