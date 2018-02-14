<template>
    <div class="container m-t-20">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title">
                            Referrals
                        </div>
                    </div>

                    <div class="box-body">
    					<table id="refferalsTable" class="table table-striped table-bordered">
    						<thead>
    							<tr>
    								<th colspan="2">Applicants</th>
    								<th colspan="2">Sales</th>
    							</tr>
    							<tr>
    								<th>New</th>
    								<th>Total</th>
    								<th>Current month</th>
    								<th>Last 12 months</th>
    							</tr>
    						</thead>
    						<tbody>
    								<tr>
    									<td class="text-center">{{ newApplicantsCount }}</td>
    									<td class="text-center">{{ applicantsCount }}</td>
    									<td class="text-right">${{ curMonthSales | amount }}</td>
    									<td class="text-right">${{ lastYearSales | amount }}</td>
    								</tr>
    						</tbody>
    					</table>
    					<br>
    					<table id="refferalsByMoonthTable" class="table table-striped table-bordered">
    						<thead>
    							<tr>
    								<th>Month</th>
    								<th>Applicants</th>
    								<th>Sales</th>
    							</tr>
    						</thead>
    						<tbody>
                                <tr v-for="item in monthlyArr">
                                    <td>{{ moment(item.month.date).format('MMMM YYYY') }}</td>
                                    <td>{{ item.applicants }}</td>
                                    <td>${{ item.sales | amount }}</td>
                                </tr>
    						</tbody>
    					</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'home',
        data() {
            return {
                applicantsCount: 0,
                curMonthSales: 0,
                lastYearSales: 0,
                newApplicantsCount: 0,
                monthlyArr: []
            }
        },
        methods: {
            getData() {
                axios.get('applicants')
                .then(response => {
                    this.applicantsCount = response.data.applicantsCount
                    this.curMonthSales = response.data.curMonthSales
                    this.lastYearSales = response.data.lastYearSales
                    this.newApplicantsCount = response.data.newApplicantsCount
                    this.monthlyArr = response.data.monthlyArr
                })
            },
            moment(date) {
                return moment(date)
            }
        },
        created() {
            this.getData()
        },
    }
</script>
