<template>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Roles</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                                <li class="breadcrumb-item active">Role Page</li>
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
                        <h3 class="card-title">Available Roles</h3>
                        

                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-outline-primary" @click="addModal = true">Add Role</button>
                            
                        </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 100%;">
                        <table class="table table-head-fixed">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role Name</th>
                                <th>Role Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(role, i) in roles"
                                :key="i"
                                v-if="roles.length">

                                <td>{{role.id}}</td>
                                <td>{{role.role_name}}</td>
                                <td>{{role.role_desc}}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary" @click="showEditModal(role, i)" >Edit</button>
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
        <!-- create new role modal-->
        <Modal v-model="addModal" title="Add Role" :mask-closable="false">
            <Input v-model="data.role_name" prefix="ios-contact"  size="large" maxlength="40" show-word-limit placeholder="Role Name" />
            <div class="space"></div>
            <Input v-model="data.role_desc" size="large" maxlength="200" show-word-limit type="textarea" placeholder="Role description" />
            <div class="space"></div>
            <div slot="footer">
                <Button type="default" @click="addModal = false">Close</Button>
                <Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding">
                    {{ isAdding ? "Adding.." : "Add Role" }}
                </Button>
            </div>
        </Modal>

        <!-- Edit Trole Modal -->
        <Modal
            v-model="editModal"
            title="Edit Role"
            :mask-closable="false"
        >
            <Input v-model="editData.role_name" size="large" maxlength="40" show-word-limit placeholder="Edit role name"/>
            <div class="space"></div>
            <Input v-model="editData.role_desc" size="large" type="textarea" placeholder="Edit role description" />
            <div class="space"></div>

            <div slot="footer">
                <Button type="default" @click="editModal = false">Close</Button>
                <Button type="primary" @click="editRole">Edit Role</Button>
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
                role_name: '',
                role_desc:''
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            loading: true,
            roles: [],
            editData: {
                role_name: '',
                role_desc:''
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1
        }
    },
    methods: {
        async addRole() {
            if (this.data.role_name.trim() == "")
                return this.e("Role name is required");
            if (this.data.role_desc.trim() == "")
                return this.e("Role description is required");
            const res = await this.callApi(
                "post",
                "/app/create_role",
                this.data
            );
            if (res.status === 201) {
                this.roles.unshift(res.data);
                this.s("A new Role was added");
                this.addModal = false;
                this.data.role_name = "";
                this.data.role_desc = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.role_name) {
                        this.e(res.data.errors.role_name[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editRole() {
            if (this.editData.role_name.trim() == "")
                return this.e("Role name cannot be empty");
            if (this.editData.role_desc.trim() == "")
                return this.e("Role description cannot be empty");
            const res = await this.callApi(
                "post",
                "/app/edit_role",
                this.editData
            );
            if (res.status === 200) {
                this.roles[this.index].role_name = this.editData.role_name;
                this.roles[this.index].role_desc = this.editData.role_desc;
                this.s("Role was edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.role_name) {
                        this.e(res.data.errors.role_name[0]);
                    }
                    if (res.data.errors.role_desc) {
                        this.e(res.data.errors.role_desc[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(role, index) {
            let obj = {
                id: role.id,
                role_name: role.role_name,
                role_desc: role.role_desc,
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        showDeletingModal(role, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_role",
                data: role,
                deletingIndex: i,
                isDeleted: false
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
            /* this.deleteItem = role;
            this.deletingIndex = i;
            this.showDeleteModal = true; 
            [vuex] unknown mutation type*/
        }
    },
    async created() {
        const res = await this.callApi('get', '/app/get_role');
        if (res.status == 200) {
            this.roles = res.data;
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
                this.roles.splice(obj.deletingIndex, 1);
            }
        }
    }
};
</script>
}
</script>