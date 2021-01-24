<template>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Donations</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                                <li class="breadcrumb-item active">Donation Page</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                <h3 class="card-title">Donations Made</h3>


                                <div class="card-tools">
                                    <button type="button" class="btn btn-block btn-outline-primary" @click="addModal = true">Add Donation</button>

                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 100%;">
                                <table class="table table-head-fixed">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th>Items Type</th>
                                        <th>Item Quantity</th>
                                        <th>Donor</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(donation, i) in donations"
                                        :key="i"
                                        v-if="donations.length">

                                        <td>{{donation.id}}</td>
                                        <td>{{donation.item_name}}</td>
                                        <td>{{donation.item_type}}</td>
                                        <td>{{donation.item_quantity}} {{donation.item_unit}}</td>
                                        <td>{{donation.user.name}}</td>

                                        <td>
                                            <button type="button" class="btn btn-outline-info" @click="showAssignModal(donation, i)">Assign</button>
                                            <button type="button" class="btn btn-outline-primary" @click="showEditModal(donation, i)" >Edit</button>
                                            <button type="button" class="btn btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- create new donation modal-->
                    <Modal v-model="addModal" title="Add Donation" :mask-closable="false">
                        <Select prefix="ios-contact" filterable v-model="data.user_id" clearable placeholder="Select donor">
                            <Option :value="r.id" v-for="(r, i) in users" :key="i" v-if="users.length">{{r.name}}</Option>
                        </Select>
                        <div class="space"></div>
                        <div class="space"></div>
                        <Input v-model="data.item_name" prefix="ios-cube"  size="large" clearable placeholder="Item name" />
                        <div class="space"></div>
                        <Select prefix="ios-list" filterable v-model="data.item_type" clearable placeholder="Select item type" style="width: 400px">
                            <Option value="clothes">Clothes</Option>
                            <Option value="grocerries" >Vegetables / Greens</Option>
                            <Option value="dairy_products" >Dairy Product</Option>
                            <Option value="cereals" >Cereals / Grains</Option>
                        </Select>
                        <div class="space"></div>
                        <Input v-model="data.item_quantity" prefix="ios-stats"  size="large" :min="1" type="number" placeholder="Item quantity" />
                        <div class="space"></div>
                        <Select prefix="ios-list" v-model="data.item_unit" clearable placeholder="Select unit of measure/mass" style="width: 400px">
                            <Option value="KGs">Kilograms</Option>
                            <Option value="L" >Liters</Option>
                            <Option value="pairs" >Pairs</Option>
                            <Option value="Pckts" >Packets</Option>
                        </Select>
                        <div class="space"></div>
                        <Input v-model="data.item_desc" prefix="ios-mail" size="large" type="textarea" placeholder="Item description" />
                        <div class="space"></div>
                        <div slot="footer">
                            <Button type="default" @click="addModal = false">Close</Button>
                            <Button type="primary" @click="addDonation" :disabled="isAdding" :loading="isAdding">
                                {{ isAdding ? "Adding.." : "Add Donation" }}
                            </Button>
                        </div>
                    </Modal>

                    <!-- Edit donation Modal -->

                    <!-- Assign donations to Agency-->
                    <Modal v-model="assignModal" title="Assign Donation" :mask-closable="false">
                        <Select prefix="ios-contact" filterable v-model="assignData.agency_id" clearable placeholder="Select agency">
                            <Option :value="a.id" v-for="(a, i) in agencies" :key="i" v-if="agencies.length">{{a.agency_name}}</Option>
                        </Select>
                        <div class="space"></div>
                        <div class="space"></div>
                        <Input v-model="assignData.item_name" prefix="ios-cube" disabled size="large" clearable placeholder="Item name" />
                        <div class="space"></div>
                        <div class="space"></div>
                        <div slot="footer">
                            <Button type="default" @click="assignModal = false">Close</Button>
                            <Button type="primary" @click="assignDonation" :disabled="isAssigning" :loading="isAssigning">
                                {{ isAssigning ? "Assiging..." : "Assign Donation" }}
                            </Button>
                        </div>
                    </Modal>
                    <!-- Delete Alert modal-->
                    <delete-modal></delete-modal>
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

</template>
<script>
import { mapGetters } from "vuex";

import DeleteModal from './../../components/DeleteModal';

export default {
    components: {
        DeleteModal
    },
    data() {
        return {
            data: {
                user_id:'null',
                item_name: '',
                item_type:'',
                item_unit:'',
                item_quantity: '',
                item_desc:'',
            },
            addModal: false,
            editModal: false,
            assignModal: false,
            isAdding: false,
            isEditing: false,
            isAssigning: false,
            loading: true,
            donations: [],
            editData: {
                user_id:'',
                item_name: '',
                item_type:'',
                item_unit:'',
                item_quantity:'',
                item_desc:'',
            },
            assignData: {
                agency_id:'',
                item_name:'',
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1,
            users: [],
            agencies:[],
        }
    },
    methods: {
        async addDonation() {
            if(!this.data.user_id)
                return this.e('Please select donor is required');
            if (this.data.item_type.trim() == "")
                return this.e("Please select donotaion type");
            if (this.data.item_unit.trim() == "")
                return this.e("Include unit (kg, liters, pkts or pairs) donotaion type");
            if (this.data.item_quantity.trim() == "")
                return this.e("Input the value should be in numbers");
            if (this.data.item_desc.trim() == "")
                return this.e("Please add more information about the donation");


            const res = await this.callApi(
                "post",
                "/app/create_donation",
                this.data
            );
            if (res.status === 201) {
                this.donations.unshift(res.data);
                this.s("A new donation was added");
                this.addModal = false;
                this.data.user_id = "";
                this.data.item_name = "";
                this.data.item_type = "";
                this.data.item_unit = "";
                this.data.item_quantity = "";
                this.data.item_desc = "";

            } else {
                if (res.status == 422) {
                    if (res.data.errors.donation_name) {
                        this.e(res.data.errors.donation_name[0]);
                    }
                    if (res.data.errors.donation_email) {
                        this.e(res.data.errors.donation_email[0]);
                    }
                    if (res.data.errors.donation_type) {
                        this.e(res.data.errors.donation_type[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editDonation() {
            if (this.editData.donation_name.trim() == "")
                return this.e("Donation name cannot be empty");
            if (this.editData.donation_email.trim() == "")
                return this.e("Donation email cannot be empty");
            if (this.editData.donation_type.trim() == "")
                return this.e("Donation type cannot be empty");
            const res = await this.callApi(
                "post",
                "/app/edit_donation",
                this.editData
            );
            if (res.status === 200) {
                this.donations[this.index].donation_name = this.editData.donation_name;
                this.donations[this.index].donation_email = this.editData.donation_email;
                this.donations[this.index].donation_type = this.editData.donation_type;
                this.s("Donation was edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.donation_name) {
                        this.e(res.data.errors.donation_name[0]);
                    }
                    if (res.data.errors.donation_email) {
                        this.e(res.data.errors.donation_type[0]);
                    }
                    if (res.data.errors.donation_type) {
                        this.e(res.data.errors.donation_type[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async assignDonation() {
            if(!this.assignData.agency_id)
                return this.e('Please select angency required to disburse items');
            if (this.assignData.item_name.trim() == "")
                return this.e("Donation name cannot be empty");
            const res = await this.callApi(
                "post",
                "/app/assign_donation",
                this.assignData
            );
            if (res.status === 200) {
                this.donations[this.index].item_name = this.assignData.item_name;
                this.donations[this.index].agency_id = this.assignData.agency_id;
                this.s("Donation was assigned successfully!");
                this.assignModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.item_name) {
                        this.e(res.assignData.errors.item_name[0]);
                    }
                    if (res.data.errors.agency_id) {
                        this.e(res.assignData.errors.agency_id[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(donation, index) {
            let obj = {
                id: donation.id,
                donation_name: donation.donation_name,
                donation_type: donation.donation_type,
                donation_email: donation.donation_email,
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
         showAssignModal(donation, index) {
            let obj = {
                id: donation.id,
                item_name: donation.item_name,
            };
            this.assignData = obj;
            this.assignModal = true;
            this.index = index;
        },
        showDeletingModal(tag, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_donation",
                data: donation,
                deletingIndex: i,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
            /* this.deleteItem = tag;
            this.deletingIndex = i;
            this.showDeleteModal = true;
            [vuex] unknown mutation type*/
        }
    },
    async created() {
        const [res, resUser, resAgency] = await Promise.all([
            this.callApi('get', '/app/get_donation'),
            this.callApi('get', '/app/get_user'),
            this.callApi('get', '/app/get_agency'),
        ])
        // const res = await this.callApi('get', '/app/get_donation');
        // const resRole = await this.callApi('get', '/app/get_role');
        if (res.status == 200) {
            this.donations = res.data;
        }
        if (resAgency.status == 200) {
            this.agencies = resAgency.data;
        }
        if (resUser.status == 200) {
            this.users = resUser.data;
        } else {
            this.swr();
        }
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        getDeleteModalObj(obj) {
            console.log(obj);
            if (obj.isDeleted) {
                this.tags.splice(obj.deletingIndex, 1);
            }
        }
    }
};
</script>
