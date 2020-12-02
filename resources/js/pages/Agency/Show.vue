<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Agencies</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active">Agency Page</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Available Agencies</h3>

                                <div class="card-tools">
                                    <button
                                        type="button"
                                        class="btn btn-block btn-outline-primary"
                                        @click="addModal = true"
                                    >
                                        Add Agency
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div
                                class="card-body table-responsive p-0"
                                style="height: 100%;"
                            >
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Agency Name</th>
                                            <th>Agency Type</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(agency, i) in agencies"
                                            :key="i"
                                            v-if="agencies.length"
                                        >
                                            <td>{{ agency.id }}</td>
                                            <td>{{ agency.agency_name }}</td>
                                            <td>{{ agency.agency_desc }}</td>
                                            <td>{{ agency.agency_mobile }}</td>
                                            <td>{{ agency.agency_email }}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-info"
                                                >
                                                    View
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary"
                                                    @click="showEditModal(agency, i)">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-outline-danger">
                                                    Delete
                                                </button>
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
                <!-- create new agency modal-->
                <Modal
                    v-model="addModal"
                    title="Add Agency"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.agency_name"
                        prefix="ios-contact"
                        size="large"
                        maxlength="40"
                        show-word-limit
                        placeholder="Agency Name"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="data.agency_type"
                        prefix="ios-albums"
                        size="large"
                        placeholder="Agency Type"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="data.agency_desc"
                        size="large"
                        type="textarea"
                        placeholder="Agency description"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="data.agency_mobile"
                        prefix="ios-call"
                        size="large"
                        maxlength="10"
                        show-word-limit
                        placeholder="Agency Mobile No"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="data.agency_email"
                        prefix="ios-mail"
                        size="large"
                        placeholder="Agency Email"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="data.agency_address"
                        prefix="ios-mail"
                        size="large"
                        placeholder="Agency address"
                    />
                    <div class="space"></div>
                    <Select
                        v-model="data.agency_location"
                        filterable
                        :remote-method="remoteMethod1"
                        :loading="loading1"
                    >
                        <Option v-for="(option, index) in options1" :value="option.value" :key="index">{{option.label}}</Option>
                    </Select>
                    <Input
                        v-model="data.agency_location"
                        prefix="ios-mail"
                        size="large"
                        placeholder="Agency location"
                    />
                    <div class="space"></div>
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addAgency"
                            :disabled="isAdding"
                            :loading="isAdding"
                        >
                            {{ isAdding ? "Adding.." : "Add Agency" }}
                        </Button>
                    </div>
                </Modal>

                <!-- Edit Tagency Modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Agency"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.agency_name"
                        size="large"
                        maxlength="40"
                        show-word-limit
                        placeholder="Edit agency name"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="editData.agency_type"
                        prefix="ios-albums"
                        size="large"
                        placeholder="Edit agency Type"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="editData.agency_desc"
                        size="large"
                        type="textarea"
                        placeholder="Edit agency description"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="editData.agency_mobile"
                        prefix="ios-call"
                        size="large"
                        maxlength="10"
                        show-word-limit
                        placeholder="Edit agency Mobile No"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="editData.agency_email"
                        prefix="ios-mail"
                        size="large"
                        placeholder="Edit agency Email"
                    />

                    <div slot="footer">
                        <Button type="default" @click="editModal = false"
                            >Close</Button
                        >
                        <Button type="primary" @click="editTag"
                            >Edit Tag</Button
                        >
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

import DeleteModal from "./../../components/DeleteModal";

export default {
    components: {
        DeleteModal
    },
    data() {
        return {
            data: {
                agency_name: "",
                agency_desc: "",
                agency_type: "",
                agency_mobile: "",
                agency_email: ""
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            loading: true,
            agencies: [],
            editData: {
                agency_name: "",
                agency_desc: "",
                agency_type: "",
                agency_mobile: "",
                agency_email: ""
            },
            loading1: false,
            options1: [],
            list: [
                "Mombasa",
                "Kwale",
                "Kilifi",
                "Tana River",
                "Lamu",
                "Taita/Taveta",
                "Garissa",
                "Wajir",
                "Mandera",
                "Marsabit",
                "Isiolo",
                "Meru",
                "Tharaka-Nithi",
                "Embu",
                "Kitui",
                "Machakos",
                "Makueni",
                "Nyandarua",
                "Nyeri",
                "Kirinyaga",
                "Muranga",
                "Kiambu",
                "Turkana",
                "West Pokot",
                "Samburu",
                "Trans Nzoia",
                "Uasin Gishu",
                "Elgeyo/Marakwet",
                "Nandi",
                "Baringo",
                "Laikipia",
                "Nakuru",
                "Narok",
                "Kajiado",
                "Kericho",
                "Bomet",
                "Kakamega",
                "Vihiga",
                "Bungoma",
                "Busia",
                "Siaya",
                "Kisumu",
                "Homa Bay",
                "Migori",
                "Kisii",
                "Nyamira",
                "Nairobi"
            ],
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1
        };
    },
    methods: {
        async addAgency() {
            if (this.data.agency_name.trim() == "")
                return this.e("Agency name is required");
            if (this.data.agency_desc.trim() == "")
                return this.e("Agency description is required");
            if (this.data.agency_type.trim() == "")
                return this.e("Agency type is required");
            if (this.data.agency_mobile.trim() == "")
                return this.e("Mobile or telephone number is required");
            if (this.data.agency_email.trim() == "")
                return this.e("Email is required");
            const res = await this.callApi(
                "post",
                "/app/create_agency",
                this.data
            );
            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.s("A new agency was added");
                this.addModal = false;
                this.data.agency_name = "";
                this.data.agency_desc = "";
                this.data.agency_email = "";
                this.data.agency_mobile = "";
                this.data.agency_type = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.agency_name) {
                        this.e(res.data.errors.agency_name[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editAgency() {
            if (this.editData.agency_name.trim() == "")
                return this.e("Agency name cannot be empty");
            const res = await this.callApi(
                "post",
                "/app/edit_agency",
                this.editData
            );
            if (res.status === 200) {
                this.agencies[
                    this.index
                ].agency_name = this.editData.agency_name;
                this.s("Agency was edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.agency_name) {
                        this.e(res.data.errors.agency_name[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(agency, index) {
            let obj = {
                id: agency.id,
                agency_name: agency.agency_name,
                agency_desc: agency.agency_desc,
                agency_type: agency.agency_type,
                agency_mobile: agency.agency_mobile,
                agency_email: agency.agency_email
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        showDeletingModal(tag, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_agency",
                data: agency,
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
        const res = await this.callApi("get", "/app/get_agency");
        if (res.status == 200) {
            this.agencies = res.data;
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
