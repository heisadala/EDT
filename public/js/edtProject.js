import { NAMED_COLORS } from "./edtColor.js";

export class Project {
    
    catIncomes = [];
    catExpenses = [];

    constructor(name, colorIndex, table, expenses=0, incomes=0) {
      this.name = name;
      this.color = NAMED_COLORS[colorIndex];
      this.table = table;
      this.expenses = expenses;
      this.incomes = incomes;
   }

   setIncExp () {
    var localExpenses = 0;
    var localIncomes = 0;
    var i;
    for (i=0; i < this.table.length; i++) {
        if (Number(this.table[i].debit) > 0) {
          localExpenses = localExpenses + Number(this.table[i].debit*100);
        }
        if (Number(this.table[i].credit) > 0) {
          localIncomes = localIncomes + Number(this.table[i].credit*100);
        }
    }
    this.expenses = localExpenses/100;
    this.incomes = localIncomes/100;
  }

  setCategories (category, categoryIndex) {
    var localExpenses = [];
    var localIncomes = [];
    localExpenses[categoryIndex] = 0;
    localIncomes[categoryIndex] = 0;
    var i;
    
    // console.log('setCategories', category, categoryIndex);
    for (i=0; i < this.table.length; i++) {
        if ((Number(this.table[i].debit) > 0) && (this.table[i].category == category)) {
          localExpenses[categoryIndex] = localExpenses[categoryIndex] + Number(this.table[i].debit*100);
        }
        if ((Number(this.table[i].credit) > 0) && (this.table[i].category == category)) {
          localIncomes[categoryIndex] = localIncomes[categoryIndex] + Number(this.table[i].credit*100);
        }
    }
    this.catExpenses[categoryIndex] = localExpenses[categoryIndex]/100;
    this.catIncomes[categoryIndex] = localIncomes[categoryIndex]/100;
  }

    getName(){
      return this.name;
    }

    getColor(){
      return this.color;
    }
    getExpenses() {
      return this.expenses;
    }
    getIncomes() {
      return this.incomes;
    }
    getCatExpenses(index) {
      return this.catExpenses[index];
    }
    getCatIncomes(index) {
      return this.catIncomes[index];
    }

  }
