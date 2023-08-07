<template>
    <div class="container">
        <div class="d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Report</h5>
                    <div class="tgl d-flex">
                        <input type="month" class="form-control bulan" v-model="selectedMonth" @change="fetchReport">
                        <button @click="exportToExcel" class="btn btn-success">Export</button>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Category</h6>
                        </th>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Amount</h6>
                        </th>
                        <th class="border-bottom-0">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Salary</h6></td>
                        <td class="border-bottom-0">
                            {{ salary }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Other Income</h6></td>
                        <td class="border-bottom-0">
                            {{ otherIncome }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Total Income</h6></td>
                        <td class="border-bottom-0">
                            {{ totalIncome }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Family Expense</h6></td>
                        <td class="border-bottom-0">
                            {{ familyExpanse }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Transport Expense</h6></td>
                        <td class="border-bottom-0">
                            {{ transportExpense }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Meal Expense</h6></td>
                        <td class="border-bottom-0">
                            {{ mealExpense }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Total Expense</h6></td>
                        <td class="border-bottom-0">
                            {{ totalExpense }}
                        </td>
                      </tr>
                      <tr>
                        <td class="border-bottom-0"><h6 class="fw-semibold mb-0">Net Income</h6></td>
                        <td class="border-bottom-0">
                            {{ netIncome }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
    </div>
</template>

<style>
.tgl{
    width: 300px;
}
.bulan{
    margin-right: 10px;
}
</style>

<script>
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';
import axios from "axios";

export default {
  data() {
    return {
      selectedMonth: '',
      salary: '',
      otherIncome: '',
      totalIncome: '',
      familyExpanse: '',
      transportExpense: '',
      mealExpense: '',
      totalExpense:'',
      netIncome:'',
      tableData: [
        { category: 'Salary', amount: this.salary },
        { category: 'Other Income', amount: this.otherIncome },
        { category: 'Total Income', amount: this.totalIncome },
        { category: 'Family Expense', amount: this.familyExpanse },
        { category: 'Transport Expense', amount: this.transportExpense },
        { category: 'Meal Expense', amount: this.mealExpense },
        { category: 'Total Expense', amount: this.totalExpense },
        { category: 'Net Income', amount: this.netIncome },
      ]
    };
  },
  created() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0");
    this.selectedMonth = `${year}-${month}`;
    this.fetchReport();
  },
  methods: {
    fetchReport() {
      const month = this.selectedMonth.split("-")[1];

      const url = `/api/report/${month}`;
      axios
        .get(url)
        .then((response) => {
          const dataReport = response.data;
          this.salary = dataReport.salary.reduce((total, item) => total + item.credit, 0);
          this.otherIncome = dataReport.otherIncome.reduce((total, item) => total + item.credit, 0);
          this.totalIncome = this.salary + this.otherIncome;
          this.familyExpanse = dataReport.familyExpanse.reduce((total, item) => total + item.debit, 0);
          this.transportExpense = dataReport.transportExpense.reduce((total, item) => total + item.debit, 0);
          this.mealExpense = dataReport.mealExpense.reduce((total, item) => total + item.debit, 0);
          this.totalExpense = this.familyExpanse + this.transportExpense + this.mealExpense;
          this.netIncome = this.totalIncome - this.totalExpense;

          this.tableData = [
          { category: 'Salary', amount: this.salary },
          { category: 'Other Income', amount: this.otherIncome },
          { category: 'Total Income', amount: this.totalIncome },
          { category: 'Family Expense', amount: this.familyExpanse },
          { category: 'Transport Expense', amount: this.transportExpense },
          { category: 'Meal Expense', amount: this.mealExpense },
          { category: 'Total Expense', amount: this.totalExpense },
          { category: 'Net Income', amount: this.netIncome },
        ];
        })
        .catch((error) => {
          console.error("Error fetching categories:", error);
        });
    },
    exportToExcel() {
        const data = [
    ['', this.selectedMonth], // Tambah baris untuk informasi bulan dan tahun
    ['Category', 'Amount'] // Header kolom
  ];
      
      // Mengumpulkan data dari tabelData ke dalam format array 2D
      this.tableData.forEach(item => {
        data.push([item.category, item.amount]);
      });

      const ws = XLSX.utils.aoa_to_sheet(data);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

      // Menghasilkan file Excel menggunakan writeBuffer
      const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
      const blob = new Blob([wbout], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      
      // Mendownload file Excel menggunakan pustaka file-saver
      saveAs(blob, 'report.xlsx');
    },
  },
};
</script>