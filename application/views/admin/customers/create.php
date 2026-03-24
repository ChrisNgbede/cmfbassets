<style type="text/css">
  #photo-preview{
    width: 100%;
  }

</style>

  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"><?= $post->id ? 'Edit' : 'Create' ?> Post or News</h3>
          </div>
          <div class="d-inline-block float-right">
             <a href="<?= base_url('admin/blog'); ?>" class="btn btn-success">List Posts</a>
          </div>
        </div>
        <div class="card-body">
   
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open_multipart( base_url('admin/blog/create')); ?>
             <input type="hidden" name="id" id="postid" value="<?php echo $post->id; ?>" />
            <div class="row">
                  <!-- /.card-header -->
              
                      <div class="form-group col-md-12">
                        <label for="title" > Title</label>
                         <?= form_input('title', $post->title, 'class="form-control" id="title"'); ?>
                      </div>
                       <div class="form-group col-md-3">
                          <label>
                            Category
                          </label>
                            <?php
                              $cat[''] = "select category";
                              foreach($categories as $category) {
                                  $cat[$category->id] = $category->name;
                              }
                              ?>
                              <?= form_dropdown('category', $cat, $post->category, 'class="form-control select2" id="category"  required="required" style="width:100%;"'); ?>
                           </div> 
                      <div class="form-group col-md-3">
                        <label for="title" > Publishing</label>
                        <select name="published" class="form-control">
                          <option value="1">Publish</option>
                          <option value="0">Draft</option>
                        </select>
                      </div>
                      <!-- <div class="form-group col-md-2">
                        <label for="title" > Post Type</label>
                        <select name="posttype" class="form-control">
                          <option value="news">Post</option>
                          <option value="post">Blog</option>
                        </select>
                      </div> -->
                      <input type="hidden" name="posttype" value="post">
                       
                       <?php if ($post->id > 0): ?>
                        <?php 
                          $tagz = getalldata('post_tags',array('postid'=>$post->id));
                        ?>
                        
                        
                             <?php if (empty($tagz)): ?>
                              <div class="form-group col-md-6">
                         
                                  <label> Tags </label><small class="text-muted"> You can select multiple tags or add new</small>
                              <span class="badge bg-secondary">no tags</span>
                            <?php else: ?>
                              <?php foreach ($tagz as $tag): ?>
                                <?php $tag_id_arr[] = $tag->tagid ?>
                              <?php endforeach ?>
                            <?php endif ?>

                           <select name="tags[]" class="form-control tageditselect2" multiple="multiple" style="width:100%;">
                                <?php if (empty($tag_id_arr)): ?>
                                    <?php foreach($tags as $row){
                                      echo '<option value="'.$row->id.'">'.$row->name.'</option>'; 
                                    }?>
                                <?php else: ?>
                                   <?php foreach ($tags as $tag): ?>
                                     
                                       <option value="<?= $tag->id?>" <?= in_array($tag->id, $tag_id_arr) ? 'selected': '' ?> > <?php echo $tag->name ?></option>
                                  <?php endforeach ?>
                                <?php endif ?>
                               
                              </select>

                               
                            </div>
                       <?php else: ?>
                        <div class="form-group col-md-6">
                            <label> Tags </label><small class="text-muted"> You can select multiple tags or add new</small>
                           <select name="tags[]" class="form-control form-control-lg tagselect2" multiple="multiple" id="tags" >
                              <?php
                              foreach($tags as $row)
                              {
                                echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                              }
                              ?>
                            </select>
                        </div>
                       <?php endif ?>
                
                      <div class="form-group col-md-3">
                        <label for="photo">Featured image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="photo" id="photo" accept="" onchange="showPreview(event);">
                            <label class="custom-file-label" for="photo">Select Image</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                         <div class="preview">
                            <img id="photo-preview">
                          </div>
                           <?php if (!empty($post->featured_image)): ?>
                                  <img src="<?= base_url('uploads/').$post->featured_image;?>" style="width:400px;" alt="" id="edit-image" >
                               <?php endif ?>
                      </div>
                     
                  
                     <div class="form-group col-md-12">
                        <label for="content" >Content</label>
                        <?= form_textarea('content', $post->content, 'class="form-control summernote" id="content"'); ?>
                      </div>
                     
                      <div class="col-md-12">
                            <input type="submit" name="submit" value="Save" class="btn btn-success btn-lg">
                    </div>
          </div>
          <?php echo form_close(); ?>
        </div>  
    </section> 
</div>
  <script type="text/javascript">
    $(function(){
      $('.summernote').summernote({
          height: 200,
      });
    });

  function showPreview(event){
  if(event.target.files.length > 0){
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("photo-preview");
    preview.src = src;
    $("#edit-image").hide();
  }

}
</script>
