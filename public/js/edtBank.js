import { BANK_COLORS } from "./edtColor.js";

export class Bank {

    projectIncomes = [];
    projectExpenses = [];

    constructor(name, colorIndex, table, expenses=0, incomes=0, savingsOut=0, savingsIn=0) {
      this.name = name;
      this.color = BANK_COLORS[colorIndex];
      this.table = table;
      this.expenses = expenses;
      this.incomes = incomes;
      this.savingsOut = savingsOut;
      this.savingsIn = savingsIn;
    }

    setIncExp () {
      var localExpenses = 0;
      var localIncomes = 0;
      var localSavingsOut = 0;
      var localSavingsIn = 0;
      var i;
      for (i=0; i < this.table.length; i++) {
        if ((Number(this.table[i].debit) > 0) && (this.table[i].assignment != 'AUTRE') && (this.table[i].assignment != 'INTERN')) {
          localExpenses = localExpenses + Number(this.table[i].debit*100);
        }
        if ((Number(this.table[i].debit) > 0) && (this.table[i].assignment == 'INTERN')) {
          localSavingsOut = localSavingsOut + Number(this.table[i].debit*100);
        }
        if ((Number(this.table[i].credit) > 0) && (this.table[i].assignment != 'AUTRE') && (this.table[i].assignment != 'INTERN')) {
          localIncomes = localIncomes + Number(this.table[i].credit*100);
        }
        if ((Number(this.table[i].credit) > 0) && (this.table[i].assignment == 'INTERN')) {
          localSavingsIn = localSavingsIn + Number(this.table[i].credit*100);
        }
      }
      this.expenses = localExpenses/100;
      this.incomes = localIncomes/100;
      this.savingsOut = localSavingsOut/100;
      this.savingsIn = localSavingsIn/100;
    }

    setProjects (project, projectIndex) {
      var localExpenses = [];
      var localIncomes = [];
      localExpenses[projectIndex] = 0;
      localIncomes[projectIndex] = 0;
      var i;
      // console.log('setCategories', category, categoryIndex);
      for (i=0; i < this.table.length; i++) {
          if ((Number(this.table[i].debit) > 0) && (this.table[i].assignment == project)) {
            localExpenses[projectIndex] = localExpenses[projectIndex] + Number(this.table[i].debit*100);
          }
          if ((Number(this.table[i].credit) > 0) && (this.table[i].assignment == project)) {
            localIncomes[projectIndex] = localIncomes[projectIndex] + Number(this.table[i].credit*100);
          }
      }
      this.projectExpenses[projectIndex] = localExpenses[projectIndex]/100;
      this.projectIncomes[projectIndex] = localIncomes[projectIndex]/100;
      // console.log('setProjects', project, this.projectExpenses[projectIndex], this.projectIncomes[projectIndex]);
    }
  
    
    getName(){
      return this.name;
    }

    getColor(){
        return this.color;
    }
   
    getExpenses(){
      return this.expenses;
    }

    getIncomes(){
      return this.incomes;
    }

    getSavingsOut(){
      return this.savingsOut;
    }

    getSavingsIn(){
      return this.savingsIn;
    }
    getProjectExpenses(index) {
      return this.projectExpenses[index];
    }
    getProjectIncomes(index) {
      return this.projectIncomes[index];
    }

  }

