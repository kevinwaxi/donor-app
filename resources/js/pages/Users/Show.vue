<template>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Users</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                                <li class="breadcrumb-item active">User Page</li>
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
                        <h3 class="card-title">Available Users</h3>
                        

                        <div class="card-tools">
                            <button type="button" class="btn btn-block btn-outline-primary" @click="addModal = true">Add User</button>
                            
                        </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 100%;">
                        <table class="table table-head-fixed">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, i) in users"
                                :key="i"
                                v-if="users.length">

                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.type}}</td>
                                <td>{{user.email}}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-info" >View</button>
                                    <button type="button" class="btn btn-outline-primary" @click="showEditModal(user, i)" >Edit</button>
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
        <!-- create new user modal-->
        <Modal v-model="addModal" title="Add User" :mask-closable="false">
            <Input v-model="data.user_name" prefix="ios-contact"  size="large" maxlength="40" show-word-limit placeholder="User Name" />
            <div class="space"></div>
            <!-- this is the dynamically generated roles from exsisting data-->
            <Select prefix="ios-nuclear" v-model="data.role_id"  placeholder="Select user type">
                <Option :value="r.role_name" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.role_name}}</Option>
                <!-- <Option value="Editor" >Editor</Option> -->
            </Select>
            <div class="space"></div>
            <Input v-model="data.user_email" prefix="ios-mail" size="large" placeholder="User Email" />
            <div slot="footer">
                <Button type="default" @click="addModal = false">Close</Button>
                <Button type="primary" @click="addUser" :disabled="isAdding" :loading="isAdding">
                    {{ isAdding ? "Adding.." : "Add User" }}
                </Button>
            </div>
        </Modal>

        <!-- Edit Tuser Modal -->
        <Modal
            v-model="editModal"
            title="Edit User"
            :mask-closable="false"
        >
            <Input v-model="editData.user_name" size="large" maxlength="40" show-word-limit placeholder="Edit user name"/>
            <div class="space"></div>
            <Input v-model="editData.user_type" prefix="ios-albums" size="large" placeholder="Edit user Type" />
            <div class="space"></div>
            <Input v-model="editData.user_desc" size="large" type="textarea" placeholder="Edit user description" />
            <div class="space"></div>
            <Input v-model="editData.user_mobile" prefix="ios-call" size="large" maxlength="10" show-word-limit placeholder="Edit user Mobile No" />
            <div class="space"></div>
            <Input v-model="editData.user_email" prefix="ios-mail" size="large" placeholder="Edit user Email" />

            <div slot="footer">
                <Button type="default" @click="editModal = false">Close</Button>
                <Button type="primary" @click="editTag">Edit Tag</Button>
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
                name: '',
                email:'',
                type:'null',
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            loading: true,
            users: [],
            editData: {
                name: '',
                type:'',
                email:''
            },
            index: -1,
            showDeleteModal: false,
            isDeleting: false,
            deleteItem: {},
            deletingIndex: -1,
            roles: [],
        }
    },
    methods: {
        async addUser() {
            if (this.data.user_name.trim() == "")
                return this.e("User name is required");
            if (this.data.user_type.trim() == "")
                return this.e("User type is required");
            const res = await this.callApi(
                "post",
                "/app/create_user",
                this.data
            );
            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.s("A new user was added");
                this.addModal = false;
                this.data.user_name = "";
                this.data.user_email = "";
                this.data.user_type = "";
            } else {
                if (res.status == 422) {
                    if (res.data.errors.user_name) {
                        this.e(res.data.errors.user_name[0]);
                    }
                    if (res.data.errors.user_email) {
                        this.e(res.data.errors.user_email[0]);
                    }
                    if (res.data.errors.user_type) {
                        this.e(res.data.errors.user_type[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editUser() {
            if (this.editData.user_name.trim() == "")
                return this.e("User name cannot be empty");
            if (this.editData.user_email.trim() == "")
                return this.e("User email cannot be empty");
            if (this.editData.user_type.trim() == "")
                return this.e("User type cannot be empty");
            const res = await this.callApi(
                "post",
                "/app/edit_user",
                this.editData
            );
            if (res.status === 200) {
                this.users[this.index].user_name = this.editData.user_name;
                this.users[this.index].user_email = this.editData.user_email;
                this.users[this.index].user_type = this.editData.user_type;
                this.s("User was edited successfully!");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.user_name) {
                        this.e(res.data.errors.user_name[0]);
                    }
                    if (res.data.errors.user_email) {
                        this.e(res.data.errors.user_type[0]);
                    }
                    if (res.data.errors.user_type) {
                        this.e(res.data.errors.user_type[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        showEditModal(user, index) {
            let obj = {
                id: user.id,
                user_name: user.user_name,
                user_type: user.user_type,
                user_email: user.user_email,
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        showDeletingModal(tag, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "app/delete_user",
                data: user,
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
        const [res, resRole] = await Promise.all([
            this.callApi('get', '/app/get_user'),
            this.callApi('get', '/app/get_role'),
        ])
        // const res = await this.callApi('get', '/app/get_user');
        // const resRole = await this.callApi('get', '/app/get_role');
        if (res.status == 200) {
            this.users = res.data;
        }
        if (resRole.status == 200) {
            this.roles = resRole.data;
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
}
</script>