<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Families</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active">Family Page</li>
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
                                <h3 class="card-title">Available Families</h3>

                                <div class="card-tools">
                                    <button
                                        type="button"
                                        class="btn btn-block btn-outline-primary"
                                        @click="addModal = true"
                                    >
                                        Add Family
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div
                                class="card-body table-responsive p-0"
                                style="height: 100%"
                            >
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Family Name</th>
                                            <th>Camp site</th>
                                            <th>Number of children</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(family, i) in families"
                                            :key="i"
                                            v-if="families.length"
                                        >
                                            <td>{{ family.id }}</td>
                                            <td>{{ family.surname }}</td>
                                            <td>
                                                {{
                                                    family.targetsite.site_name
                                                }}
                                            </td>
                                            <td>{{ family.children_no }}</td>

                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary"
                                                    @click="
                                                        showEditModal(family, i)
                                                    "
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-danger"
                                                >
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
                <!-- create new family modal-->
                <Modal
                    v-model="addModal"
                    title="Add Family"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.surname"
                        prefix="ios-contact"
                        size="large"
                        maxlength="40"
                        show-word-limit
                        placeholder="Family Name"
                    />
                    <div class="space"></div>
                    <Select
                        prefix="ios-home"
                        filterable
                        v-model="data.targetsite_id"
                        clearable
                        placeholder="Select camp site"
                    >
                        <Option
                            :value="a.id"
                            v-for="(a, i) in targetsites"
                            :key="i"
                            v-if="targetsites.length"
                            >{{ a.site_name }}</Option
                        >
                    </Select>
                    <div class="space"></div>
                    <InputNumber :max="10" :min="1" v-model="data.children_no">
                    </InputNumber>
                    <div class="space"></div>
                    <DatePicker
                        v-model="data.date_of_birth"
                        type="date"
                        :start-date="new Date(1970, 1, 1)"
                        placeholder="Select date of birth"
                        style="width: 200px"
                    ></DatePicker>
                    <div class="space"></div>
                    <!-- <Input
                        v-model="data.isRefugee"
                        prefix="ios-contact"
                        size="large"
                        maxlength="40"
                        show-word-limit
                        placeholder="Is Refugee"
                    /> -->
                    <Checkbox v-model="data.isRefugee">Refugee ?</Checkbox>
                    <div class="space"></div>
                    <Input
                        v-model="data.countryOrigin"
                        prefix="ios-contact"
                        size="large"
                        maxlength="40"
                        show-word-limit
                        placeholder="Country of Origin"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="data.family_desc"
                        size="large"
                        maxlength="200"
                        show-word-limit
                        type="textarea"
                        placeholder="Family description"
                    />
                    <div class="space"></div>
                    <div slot="footer">
                        <Button type="default" @click="addModal = false"
                            >Close</Button
                        >
                        <Button
                            type="primary"
                            @click="addFamily"
                            :disabled="isAdding"
                            :loading="isAdding"
                        >
                            {{ isAdding ? "Adding.." : "Add Family" }}
                        </Button>
                    </div>
                </Modal>

                <!-- Edit Tfamily Modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Family"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.family_name"
                        size="large"
                        maxlength="40"
                        show-word-limit
                        placeholder="Edit family name"
                    />
                    <div class="space"></div>
                    <Input
                        v-model="editData.family_desc"
                        size="large"
                        type="textarea"
                        placeholder="Edit family description"
                    />
                    <div class="space"></div>

                    <div slot="footer">
                        <Button type="default" @click="editModal = false"
                            >Close</Button
                        >
                        <Button type="primary" @click="editFamily"
                            >Edit Family</Button
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
                site_id: "",
                surname: "",
                children_no: null,
                date_of_birth: "",
                isRefugee: false,
                countryOrigin: "",
                location: "",
                history: "",
                isDisabled: "",
                diasabilityDesc: ""
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            loading: true,
            families: [],
            targetsites: [],
            editData: {
                site_id: "",
                surname: "",
                children_no: "",
                date_of_birth: "",
                isRefugee: "",
                countryOrigin: "",
                location: "",
                history: "",
                isDisabled: "",
                diasabilityDesc: ""
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1
        };
    },
    methods: {
        async addFamily() {
            if (this.data.surname.trim() == "")
                return this.e("Family name is required");
            if (this.data.children_no.trim() == "")
                return this.e("Number of children is required");
            const res = await this.callApi(
                "post",
                "/app/create_family",
                this.data
            );
            if (res.status === 201) {
                this.families.unshift(res.data);
                this.s("Family was added");
                this.addModal = false;
                this.data.surname = "";
                this.data.family_desc = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.surname) {
                        this.e(res.data.errors.surname[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editFamily() {
            if (this.editData.surname.trim() == "")
                return this.e("Family name cannot be empty");
            if (this.editData.family_desc.trim() == "")
                return this.e("Family description cannot be empty");
            const res = await this.callApi(
                "post",
                "/app/edit_family",
                this.editData
            );
            if (res.status === 200) {
                this.families[this.index].surname = this.editData.family_name;
                this.families[
                    this.index
                ].family_desc = this.editData.family_desc;
                this.s("Family was edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.surname) {
                        this.e(res.data.errors.surname[0]);
                    }
                    if (res.data.errors.family_desc) {
                        this.e(res.data.errors.family_desc[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(family, index) {
            let obj = {
                id: family.id,
                surname: family.surname,
                family_desc: family.family_desc
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        showDeletingModal(family, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_family",
                data: family,
                deletingIndex: i,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
            /* this.deleteItem = family;
            this.deletingIndex = i;
            this.showDeleteModal = true;
            [vuex] unknown mutation type*/
        }
    },
    async created() {
        const [res, resCamp] = await Promise.all([
            this.callApi("get", "/app/get_family"),
            this.callApi("get", "/app/get_site")
        ]);
        if (res.status == 200) {
            this.families = res.data;
        }
        if (resCamp.status == 200) {
            this.targetsites = resCamp.data;
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
                this.families.splice(obj.deletingIndex, 1);
            }
        }
    }
};
</script>
