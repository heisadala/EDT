import { NAMED_COLORS } from "./myColor.js";

export class Category {

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
          if (Number(this.table[i].amount) < 0) {
            localExpenses = localExpenses + Number(this.table[i].amount*100);
          }
          if (Number(this.table[i].amount) > 0) {
            localIncomes = localIncomes + Number(this.table[i].amount*100);
          }
      }
      this.expenses = localExpenses/100;
      this.incomes = localIncomes/100;
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
  };

