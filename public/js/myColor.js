// aqua: '#00FFFF',
// chartreuse: '#7FFF00',
// fuchsia: '#FF00FF',
// yellow: '#FFFF00',

// red: '#FF0000',
// mediumSlateBlue: '#7B68EE',
// lightseagreen : '#20B2AA',
// orangered : '#FF4500',  

// darkviolet : '#9400D3',  
// silver : '#C0C0C0',  
// green : '#008000',  
// mediumblue : '#0000CD',  

// plum : '#DDA0DD',  
// orange : '#FFA500',  
// lightskyblue : '#87CEFA',  
// salmon : '#FA8072',  

// export const NAMED_COLORS = [
//   CHART_COLORS.aqua,
//   CHART_COLORS.chartreuse,
//   CHART_COLORS.fuchsia,
//   CHART_COLORS.yellow,

//   CHART_COLORS.red,
//   CHART_COLORS.mediumSlateBlue,
//   CHART_COLORS.lightseagreen,
//   CHART_COLORS.orangered,  

//   CHART_COLORS.darkviolet,  
//   CHART_COLORS.silver,  
//   CHART_COLORS.green,  
//   CHART_COLORS.mediumblue,  

//   CHART_COLORS.plum,  
//   CHART_COLORS.orange,  
//   CHART_COLORS.lightskyblue,  
//   CHART_COLORS.salmon,  
// ];
// pastel_blue: '#B4CFEC',
// beige: '#EDD2B4',
// pastel_yellow: '#FAF884',
// blue: '#8486FA',

// pastel_red : '#F67280',
// electric_blue : '#71F5E8',  
// pastel_green: '#77DD77',
// violet: '#DE78DE',

// pastel_orange : '#F8B88B',  
// light_blue : '#8BCAF7',  
// pastel_purple : '#F2A2E8',  
// green : '#A2F2AD',  

// pastel_indigo : '#8686AF',  
// olive : '#B0B087',  
// lightskyblue : '#87CEFA',  
// salmon : '#FA8072',  


export const CHART_COLORS = {

  yellow: '#FFF202',
  lightblue : '#A7CAF0',
  rose: '#E0A1C0',
  green: '#BEE005',
  orange: '#95ADCF',
  iceblue : '#E0617F',  
  red: '#DE803E',
  
  cmb: '#DC3545',
  cmz: '#FFC700',
  nickel: '#CC4C00',
  ca: '#0271A4',

  debit: '#F75D59',
  credit: '#319731',

};

export const BANK_COLORS = [
  CHART_COLORS.ca,
  CHART_COLORS.cmb,
  CHART_COLORS.cmz,
  CHART_COLORS.nickel,
]

export const NAMED_COLORS = [
  CHART_COLORS.yellow,
  CHART_COLORS.lightblue,
  CHART_COLORS.rose,
  CHART_COLORS.green,
  CHART_COLORS.orange,
  CHART_COLORS.iceblue,  
  CHART_COLORS.red,

];
//
  // const getExpenses = function (table) {
  //   var expenses = 0;
  //   var income = 0;
  //   for (i=0; i < table.length; i++) {
  //     if (Number(table[i].montant) < 0) {
  //         expenses = expenses + Number(table[i].montant)*100;
  //     }
  //     if (Number(table[i].montant) > 0) {
  //       income = income + Number(table[i].montant*100);
  //     }
  //   }
  //   console.log('DEPENSES',expenses/100);
  //   console.log('RECETTES',income/100);
  //   return [expenses/100, income/100];
  // }
  // const bank_depense = [];
  // for (i=0; i<bankInfoObjects.length;i++) {
  //   bank_depense[i] = {banque: bankInfoObjects[i].banque, depense: "0"};
  //   console.log('BANK DEPENSES',bank_depense[i].banque);
  // }

  // var expenses = 0;
  // var income = 0;
  // for (i=0; i < entryInfoObjects.length; i++) {
  //   if (Number(entryInfoObjects[i].montant) < 0) {
  //       expenses = expenses + Number(entryInfoObjects[i].montant)*100;
  //       // console.log('DEPENSE',Number(entryInfoObjects[i].montant), 'DEPENSES', expenses);
  //   }
  //   if (Number(entryInfoObjects[i].montant) > 0) {
  //     income = income + Number(entryInfoObjects[i].montant*100);
  //   }
  // }
  // console.log('DEPENSES',expenses/100);
  // console.log('RECETTES',income/100);



  // ******************************
  // LOCAL FUNCTIONS
  // ******************************
  // const mydataIncome = {
  //   labels: [
  //     label_1,
  //     label_2,
  //     label_3
  //   ],
  //   datasets: [{
  //     label: 'My First Dataset',
  //     data: [bank_table_income[0], bank_table_income[1], bank_table_income[2]],
  //     backgroundColor: [
  //       'rgb(255, 99, 132)',
  //       'rgb(54, 162, 235)',
  //       'rgb(255, 205, 86)'
  //     ],
  //     hoverOffset: 4
  //   }]
  // };
  
  // const mydataExpenses = {
  //   labels: [
  //     label_1,
  //     label_2,
  //     label_3
  //   ],
  //   datasets: [{
  //     label: 'My First Dataset',
  //     data: [bank_table_expenses[0], bank_table_expenses[1], bank_table_expenses[2]],
  //     backgroundColor: [
  //       'rgb(255, 99, 132)',
  //       'rgb(54, 162, 235)',
  //       'rgb(255, 205, 86)'
  //     ],
  //     hoverOffset: 4
  //   }]
  // };
   // new Chart(
  //   document.getElementById('mychartIncome'),
  //   {
  //     type: 'pie',
  //     data:  mydataIncome 
  //   }
  // );

  // new Chart(
  //   document.getElementById('mychartExpenses'),
  //   {
  //     type: 'pie',
  //     data:  mydataExpenses
  //   }
  // );
 