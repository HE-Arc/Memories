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
    /*
    * reset input file when the user click to upload new file
    */
    reset()
    {
        this.$parent.path = "";
        this.$refs.files.value=null;
        this.files = [];
        this.upload_state = "";
    },
    /*
    *prepare the request to send the file to the server
    */
    handleFiles() {
      let uploadedFiles = this.$refs.files.files; //get all files

      //add them to the content to send to the server
      for (var i = 0; i < uploadedFiles.length; i++) {
        this.files.push(uploadedFiles[i]);
      }
    },

    /*
    * send the pictures to the servers
    */
    async submitFiles() {
        //foreach files to uplad
      for (let i = 0; i < this.files.length; i++) {
        if (this.files[i].id) {
          continue;
        }
        //prepare the request with the file and the memory id
        let formData = new FormData();
        formData.append("file", this.files[i]);
        formData.append("id", this.id);

        //send the data to the server
        await axios
          .post(route("memorypictures.store"), formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(
            function (data) {
                //when we got an answer, show a flash succes and update pictures in the views
               this.upload_state = "UPLOAD_SUCCES";
               this.$emit('updateData', data.data)

            }.bind(this)
          )
          .catch(function (data) {
              //if a error append show a message to the user
               this.upload_state = "UPLOAD_FAIL";
          }.bind(this));

      }
    },
  },
};
</script>
