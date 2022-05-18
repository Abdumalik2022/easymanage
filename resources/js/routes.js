// Authentication
let login = require('./components/auth/login').default
let register = require('./components/auth/register').default
let forget = require('./components/auth/forget').default
let home = require('./components/home').default
let logout = require('./components/auth/logout').default    // never forget to put ( .default )

// Employees Component
let createEmployee = require('./components/employee/create').default
let employee = require('./components/employee/index').default
let edit_employee = require('./components/employee/edit').default

// Supliers Component
let create_supplier = require('./components/suppliers/create').default
let supplier = require('./components/suppliers/index').default
let edit_supplier = require('./components/suppliers/edit').default

// Category Component
let create_category = require('./components/category/create').default
let category = require('./components/category/index').default
let edit_category = require('./components/category/edit').default

// Product Component
let create_product = require('./components/products/create').default
let product = require('./components/products/index').default
let edit_product = require('./components/products/edit').default

// Expense Component
let create_expense = require('./components/expense/create').default
let expense = require('./components/expense/index').default
let edit_expense = require('./components/expense/edit').default

// Salary Component
let salary = require('./components/salary/all_employee').default
let paysalary = require('./components/salary/create').default
let allsalary = require('./components/salary/index').default
let viewSalary = require('./components/salary/view').default
let editSalary = require('./components/salary/edit').default

//Stock
let stock = require('./components/products/stock').default
let editStock = require('./components/products/editStock').default

// Customer Component
let createCustomer = require('./components/customer/create').default
let customer = require('./components/customer/index').default
let edit_customer = require('./components/customer/edit').default

// POS
let pos = require('./components/pos/pointofsale').default

// Order
let order = require('./components/order/order').default
let viewOrder = require('./components/order/orderView').default

// Order-Search
let search = require('./components/order/searchOrder').default


export const routes = [
   { path: '/', component: login },
   { path: '/register', component: register },
   { path: '/forget', component: forget },
   { path: '/home', component: home },
   { path: '/logout', component: logout },

   // Employee
   { path: '/create-employee', component: createEmployee },
   { path: '/employee', component: employee },
   { path: '/edit-employee/:id', component: edit_employee, name: 'edit-employee' },

   // Suppliers
   { path: '/create-supplier', component: create_supplier },
   { path: '/supplier', component: supplier },
   { path: '/edit-supplier/:id', component: edit_supplier, name: 'edit-supplier' },

   // Categories
   { path: '/create-category', component: create_category },
   { path: '/category', component: category },
   { path: '/edit-category/:id', component: edit_category, name: 'edit-category' },

   // Products
   { path: '/create-product', component: create_product },
   { path: '/product', component: product },
   { path: '/edit-product/:id', component: edit_product, name: 'edit-product' },

   // Expenses
   { path: '/create-expense', component: create_expense },
   { path: '/expense', component: expense },
   { path: '/edit-expense/:id', component: edit_expense, name: 'edit-expense' },
 
   // Expenses
   { path: '/given-salary', component: salary },
   { path: '/pay-salary/:id', component: paysalary, name: 'pay-salary' },
   { path: '/salary', component: allsalary },
   { path: '/salary/view/:id', component: viewSalary, name: 'view-salary' },
   { path: '/salary/edit/:id', component: editSalary, name: 'edit-salary' },

   // Stock
   { path: '/stock', component: stock },
   { path: '/stock/edit/:id', component: editStock, name: 'edit-stock' },

   // Customer
   { path: '/create-customer', component: createCustomer },
   { path: '/customer', component: customer },
   { path: '/edit-customer/:id', component: edit_customer, name: 'edit-customer' },

   // POS
   { path: '/pos', component: pos },

   // Order
   { path: '/order', component: order },
   { path: '/view-order/:id', component: viewOrder, name: 'view-order' },

   // Order-Search
   { path: '/search', component: search },
   // { path: '/view-order/:id', component: viewOrder, name: 'view-order' },
]