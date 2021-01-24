<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Sites</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Site Page</li>
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
                <h3 class="card-title">Available Sites</h3>

                <div class="card-tools">
                  <button
                    type="button"
                    class="btn btn-block btn-outline-primary"
                    @click="addModal = true"
                  >
                    Add Site
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 100%">
                <table class="table table-head-fixed">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Site Name</th>
                      <th>Site Location</th>
                      <th>Site Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(site, i) in sites" :key="i" v-if="sites.length">
                      <td>{{ site.id }}</td>
                      <td>{{ site.site_name }}</td>
                      <td>{{ site.location }}</td>
                      <td>{{ site.desc}}</td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-outline-primary"
                          @click="showEditModal(site, i)"
                        >
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
        <!-- create new site modal-->
        <Modal v-model="addModal" title="Add Site" :mask-closable="false">
          <Input
            v-model="data.site_name"
            prefix="ios-contact"
            size="large"
            maxlength="40"
            show-word-limit
            placeholder="Site Name"
          />
          <div class="space"></div>
          <Input
            v-model="data.population"
            prefix="ios-contact"
            size="large"
            placeholder="Population Size"
          />
          <div class="space"></div>
          <Input
            v-model="data.desc"
            size="large"
            maxlength="200"
            show-word-limit
            type="textarea"
            :rows="5"
            placeholder="Site description"
          />
          <div class="space"></div>
          <Input
            v-model="data.location"
            size="large"
            placeholder="Site Loaction"
          />
          <div class="space"></div>
          <Input
            v-model="data.coordinates"
            size="large"
            maxlength="200"
            show-word-limit
            type="textarea"
            placeholder="Site coordiantes"
          />
          <div class="space"></div>
          <div slot="footer">
            <Button type="default" @click="addModal = false">Close</Button>
            <Button
              type="primary"
              @click="addSite"
              :disabled="isAdding"
              :loading="isAdding"
            >
              {{ isAdding ? "Adding.." : "Add Site" }}
            </Button>
          </div>
        </Modal>

        <!-- Edit Tsite Modal -->
        <Modal v-model="editModal" title="Edit Site" :mask-closable="false">
          <Input
            v-model="editData.site_name"
            size="large"
            maxlength="40"
            show-word-limit
            placeholder="Edit site name"
          />
          <div class="space"></div>
          <Input
            v-model="editData.site_desc"
            size="large"
            type="textarea"
            placeholder="Edit site description"
          />
          <div class="space"></div>

          <div slot="footer">
            <Button type="default" @click="editModal = false">Close</Button>
            <Button type="primary" @click="editSite">Edit Site</Button>
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
    DeleteModal,
  },
  data() {
    return {
      data: {
        site_name: "",
        coordinates: "",
        location: "",
        population:"",
        site_image: "",
        desc: "",
      },
      addModal: false,
      editModal: false,
      isAdding: false,
      loading: true,
      sites: [],
      editData: {
        site_name: "",
        coordinates: "",
        location: "",
        site_image: "",
        desc: "",
      },
      index: -1,
      showDeleteModal: false,
      isDeleting: false,
      deleteItem: {},
      deletingIndex: -1,
    };
  },
  methods: {
    async addSite() {
      if (this.data.site_name.trim() == "")
        return this.e("Site name is required");
      if (this.data.coordinates.trim() == "")
        return this.e("Input coordinates is required");
      if (this.data.location.trim() == "")
        return this.e("Please Specify the location");
        if (this.data.population.trim() == "")
        return this.e("Please Specify the location");
      if (this.data.desc.trim() == "")
        return this.e("Site description is required");
      const res = await this.callApi("post", "/app/create_site", this.data);
      if (res.status === 201) {
        this.sites.unshift(res.data);
        this.s("A new Site was added");
        this.addModal = false;
        this.data.site_name = "";
        this.data.site_desc = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.site_name) {
            this.e(res.data.errors.site_name[0]);
          }
          if (res.data.errors.coordinates) {
            this.e(res.data.errors.coordinates[0]);
          }
          if (res.data.errors.location) {
            this.e(res.data.errors.location[0]);
          }
          if (res.data.errors.desc) {
            this.e(res.data.errors.desc[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async editSite() {
      if (this.editData.site_name.trim() == "")
        return this.e("Site name cannot be empty");
      if (this.editData.coordinates.trim() == "")
        return this.e("Site name cannot be empty");
      if (this.editData.location.trim() == "")
        return this.e("Site name cannot be empty");
      if (this.editData.site_image.trim() == "")
        return this.e("Site name cannot be empty");
      if (this.editData.desc.trim() == "")
        return this.e("Site description cannot be empty");
      const res = await this.callApi("post", "/app/edit_site", this.editData);
      if (res.status === 200) {
        this.sites[this.index].site_name = this.editData.site_name;
        this.sites[this.index].coordinates = this.editData.coordinates;
        this.sites[this.index].location = this.editData.location;
        this.sites[this.index].desc = this.editData.desc;
        this.s("Site was edited successfully!");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.site_name) {
            this.e(res.data.errors.site_name[0]);
          }
          if (res.data.errors.coordinates) {
            this.e(res.data.errors.coordinates[0]);
          }
          if (res.data.errors.location) {
            this.e(res.data.errors.location[0]);
          }
          if (res.data.errors.desc) {
            this.e(res.data.errors.desc[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    showEditModal(site, index) {
      let obj = {
        id: site.id,
        site_name: site.site_name,
        coordinates: site.coordinates,
        location: site.location,
        desc: site.desc,
      };
      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    showDeletingModal(site, i) {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "app/delete_site",
        data: site,
        deletingIndex: i,
        isDeleted: false,
      };
      this.$store.commit("setDeletingModalObj", deleteModalObj);
      console.log("delete method called");
      /* this.deleteItem = site;
            this.deletingIndex = i;
            this.showDeleteModal = true;
            [vuex] unknown mutation type*/
    },
  },
  async created() {
    const res = await this.callApi("get", "/app/get_site");
    if (res.status == 200) {
      this.sites = res.data;
    } else {
      this.swr();
    }
  },
  computed: {
    ...mapGetters(["getDeleteModalObj"]),
  },
  watch: {
    getDeleteModalObj(obj) {
      console.log(obj);
      if (obj.isDeleted) {
        this.sites.splice(obj.deletingIndex, 1);
      }
    },
  },
};
</script>
}
</script>
