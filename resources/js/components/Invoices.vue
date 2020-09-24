<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Note:</h5>
                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="form-group">
                <v-select :reduce="invoice_options => invoice_options.invoice_no" placeholder="SELECT INVOICE" label="invoice_no" :options="invoice_options" @input="selected_invoice">
                </v-select>
            </div>
        </div>
        <div class="col-md-8">
            <button class="btn btn-secondary float-right" v-if="button_if === 1" @click="print_invoice"><i class="fas fa-print"></i> Print</button>
            <button class="btn btn-secondary float-right" v-else disabled><i class="fas fa-print"></i> Print</button>
            <!--<button type="button" class="btn btn-success float-right"><i class="fas fa-credit-card"></i> Submit
                    Payment
                </button> -->
            <!-- <button type="button" v-if="button_if === 1" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                </button>
                <button type="button" v-else class="btn btn-primary float-right" style="margin-right: 5px;" disabled>
                    <i class="fas fa-download"></i> Generate PDF
                </button>-->
        </div>
    </div>

    <div class="row" id="print_invoice">
        <div class="col-md-12">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> Random K Inc.
                            <small class="float-right">Date: {{ invoice_transaction === [] ? '' : invoice_transaction.created_at }}</small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info mt-3">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>Random K Inventory System</strong><br>
                            Sta Cecila Subdivision, Brgy. Gusa<br>
                            Cagayan de Oro City, PH 9000<br>
                            Phone: (804) 123-5432<br>
                            Email: admin@randomk.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>{{ invoice_transaction === [] ? '' : invoice_transaction.name }}</strong><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br>
                            Phone: (555) 539-1037<br>
                            Email: john.doe@example.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{ invoice_transaction === [] ? '' : invoice_transaction.invoice_no }}</b><br>
                        <br>
                        <b>Order ID:</b> 4F3S8J<br>
                        <b>Payment Due:</b> 2/22/2014<br>
                        <b>Account:</b> 968-34567
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover text-nowrap" id="dt_customer_trans_details">
                            <thead>
                                <tr style="text-align:center">
                                    <th>Quantity</th>
                                    <th>Barcode No</th>
                                    <th>Product Name</th>
                                    <th>Product Unit</th>
                                    <th>Selling Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="itd in invoice_transaction_details" :key="itd.barcode_no" style="text-align:center">
                                    <td>{{ itd.quantity }}</td>
                                    <td>{{ itd.barcode_no }}</td>
                                    <td>{{ itd.product_name }}</td>
                                    <td>{{ itd.product_unit }}</td>
                                    <td>{{ itd.selling_price }}</td>
                                    <td>{{ itd.total_amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row mt-3">
                    <!-- accepted payments column -->
                    <div class="col-md-6">
                        <p class="lead">Payment Methods:</p>
                        <img :src="'../img/credit/visa.png'" alt="Visa">
                        <img :src="'../img/credit/mastercard.png'" alt="Mastercard">
                        <img :src="'../img/credit/american-express.png'" alt="American Express">
                        <img :src="'../img/credit/paypal2.png'" alt="Paypal">

                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            ONGOING, FOR TESTING
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>{{ solve_subtotal }}</td>
                                </tr>
                                <tr>
                                    <th>Tax</th>
                                    <td>{{ invoice_transaction === [] ? '' : invoice_transaction.tax }}</td>
                                </tr>
                                <tr>
                                    <th>Discount:</th>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{ invoice_transaction === [] ? '' : invoice_transaction.accumulated_total }}</td>
                                </tr>
                                <tr>
                                    <th>Amount Tendered:</th>
                                    <td>{{ invoice_transaction === [] ? '' : invoice_transaction.amount_tendered }}</td>
                                </tr>
                                <tr>
                                    <th>Change:</th>
                                    <td>{{ invoice_transaction === [] ? '' : invoice_transaction.change }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.invoice -->
        </div>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
            invoice_options: [],
            invoice_transaction: [],
            invoice_transaction_details: [],
            sub_total: '',
            button_if: 0,
        }
    },
    methods: {
        load_invoices() {
            axios.get("invoice/get_invoices").then(
                ({
                    data
                }) => {
                    this.invoice_options = data

                    // this.forceRefreshInvoicesDataTable();
                });
        },
        print_invoice() {
            this.$htmlToPaper("print_invoice");
        },
        selected_invoice(invoice_no) {
            if (invoice_no === null) {
                this.button_if = 0;
                this.invoice_transaction = [];
                this.invoice_transaction_details = '';
            } else {
                this.button_if = 1;
                const get_invoice_transaction = axios.get("invoice/get_invoice_transaction/" + invoice_no);
                const get_invoice_transaction_details = axios.get("invoice/get_invoice_transaction_details/" + invoice_no);

                axios.all([get_invoice_transaction, get_invoice_transaction_details]).then(axios.spread((...data) => {
                    this.invoice_transaction = data[0].data[0];
                    this.invoice_transaction_details = data[1].data;

                    $("#dt_customer_trans_details").DataTable().destroy();
                    this.forceRefreshInvoicesDataTable();
                })).catch(errors => {
                    // react on errors.
                });

            }
        },
        forceRefreshInvoicesDataTable() {
            Vue.nextTick(function () {
                $("#dt_customer_trans_details").DataTable({
                    "ordering": false,
                    "paging": false,
                    "info": false,
                    "searching": false
                }).draw();
            });
        },
    },
    computed: {
        solve_subtotal: function () {
            var tot = 0;
            var taxable = 0;
            this.sub_total = 0;

            if (this.invoice_transaction === [] || this.invoice_transaction === '' || this.invoice_transaction === undefined || this.invoice_transaction.length === 0) {
                this.sub_total = 0;
            } else {
                tot = parseInt(this.invoice_transaction.accumulated_total);
                taxable = parseInt(this.invoice_transaction.tax);

                this.sub_total = tot - taxable;
            }

            return this.sub_total.toFixed(2);
        }
    },
    created() {
        this.load_invoices();
    }
}
</script>
