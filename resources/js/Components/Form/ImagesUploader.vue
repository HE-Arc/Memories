<template>
<div class="mb-3">
  <label for="formFile" class="form-label">Upload your memories</label>
  <input class="form-control" type="file"
      id="files"
      ref="files"
      multiple
      v-on:click="reset()"
      v-on:change="handleFiles()">
      <br>
   <a class="btn btn-success" v-on:click="submitFiles()">Submit</a>
</div>

<div class="alert alert-success" role="alert" v-if="upload_state === 'UPLOAD_SUCCES'">
   File upload with success !
</div>
<div class="alert alert-danger" role="alert" v-else-if="upload_state === 'UPLOAD_FAIL'">
   Error while importing files...
</div>
</template>

<script>
export default {
  props: ['id'],
  data() {
    return {
      files: [],
      upload_state: "",
    };
  },

  methods: {
    reset()
    {
        this.$parent.path = "salut";
        this.$refs.files.value=null;
        this.files = [];
        this.upload_state = "";
    },
    handleFiles() {
      let uploadedFiles = this.$refs.files.files;

      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
      }
    },
    submitFiles() {
      for (let i = 0; i < this.files.length; i++) {
        if (this.files[i].id) {
          continue;
        }
        let formData = new FormData();
        formData.append("file", this.files[i]);
        formData.append("id", this.id);

        axios
          .post(route("memorypictures.store"), formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(
            function (data) {
               this.upload_state = "UPLOAD_SUCCES";
               this.$emit('updateData', data.data)

            }.bind(this)
          )
          .catch(function (data) {
               this.upload_state = "UPLOAD_FAIL";
          }.bind(this));

      }
    },
  },
};
</script>
