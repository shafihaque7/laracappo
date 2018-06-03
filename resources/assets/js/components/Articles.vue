<template>

      <div>
         <h2>Articles</h2>
         <button type="button" class="btn btn-primary mb-2" @click="clearArticle()">Add</button>

           <form @submit.prevent="addArticle">
           <div class="modal modal-fullscreen" id="modalLarge" tabindex="-1" role="dialog" aria-labelledby="modalLargeLabel" aria-hidden="true">
               
               <div class="modal-dialog" role="document">
                     
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" type="text" id="modalLargeLabel"><input v-model="article.title" placeholder="Title"></h5>
                           <button @click="stopEditing" class="close" aria-label="Close">
                                 <!-- <button class="close" > -->
                               <span aria-hidden="true">&times;</span>
                           </button>

                       </div>
                        
                           <textarea type="text" id="largetextarea"class="form-control" rows="10" v-model="article.body" placeholder="Body"></textarea>
                       
                       <div class="modal-footer">
                           <!-- <button @click="stopEditing" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                           <button type="submit" class="btn btn-secondary" aria-hidden="true" data-toggle="modal" data-target="#modalLarge" >Save</button>

                          
                       </div>
                   </div>
                  
               </div>
              
           </div>
         </form>

             <h3> Search </h3>
            <input type="text" v-model= "search" class="form-control mb-4" placeholder="Search for...">
          
         <nav aria-label="Page navigation example">
               <ul class="pagination">
                 <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                  <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page}}</a></li>
                 <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a></li>
               </ul>
             </nav>
      
         

         <div class="row">
               <div class="col-md-4" v-for="article in filteredArticles" @click="editArticle(article)"   v-bind:key="article.id">
           
                 <div class="card mb-4 box-shadow">
                   <div class="card-body">
                        <h5 class="card-title">{{ article.title }}</h5>
                     <p class="card-text">{{ article.sbody }}</p>
                     <div class="d-flex justify-content-between align-items-center">
                       <div class="btn-group">
                         <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                         <button type="button" class="btn btn-sm btn-outline-secondary" v-on:click.stop @click="deleteArticle(article.id)" id="deleteButton" >Delete</button>
                       </div>
                       <small class="text-muted">{{ article.label }}</small>
                     </div>
                   </div>
                 </div>
               </div>
         </div>
      </div>
      
      </template>
      
      <script>
            export default {
               data() {
                  return {
                     articles: [],
                     sarticles: [], // This is used for shortened articles
                     article: {
                        id: '',
                        title: '',
                        body: ''
                     },
                     article_id: '',
                     pagination: {},
                     edit: false,
                     search: "",
                     current_page_url: ""
                  }
               },
         
               created() {
                  this.fetchArticles();
               },
         
               methods: {
                  stopEditing(){
                     $('#modalLarge').modal('hide');
                     $('body').removeClass('modal-open');
                     $('.modal-backdrop').remove();
                     this.edit = false;
                  },
                  fetchArticles(page_url){
                     this.current_page_url = page_url;
                     let vm = this;
                     page_url = page_url || 'api/articles'
                     fetch(page_url)
                     .then(res => res.json())
                     .then(res => {
                       
                        this.articles = res.data;
            
                        vm.makePagination(res.meta, res.links);
                     })
                     .catch(err => console.log(err));
                  },
         
                  makePagination(meta, links) {
                     let pagination = {
                        current_page: meta.current_page,
                        last_page: meta.last_page,
                        next_page_url: links.next,
                        prev_page_url: links.prev
                     }
         
                      this.pagination = pagination;
                  },
         
                  deleteArticle(id){
         
                     if(confirm('Are you Sure?')){
                        fetch(`api/article/${id}`, {
                           method: 'delete'
                        })
                        .then(res => res.json())
                        .then(data => {
                           this.fetchArticles(this.current_page_url);
                           
                        })
                        .catch(err => console.log(err));
                     }
                  },
                  clearArticle(){
                     $('#modalLarge').modal('show');
                     this.edit=false;
                     this.article.id = '';
                     this.article.article_id = '';
                     this.article.title = '';
                     this.article.body = '';
                  },
         
                  addArticle() {
                     
                     if (this.article.body=="" && this.article.title==""){
                        $('#modalLarge').modal('hide');
                           $('body').removeClass('modal-open');
                           $('.modal-backdrop').remove();
                        return;
                     }
                     
                     
                     
                     if (this.edit == false){
                        this.search = "";
                        
                        // Add
                        fetch('api/article',{
                           method: 'post',
                           body: JSON.stringify(this.article),
                           headers:{
                              'content-type': 'application/json'
                           }
                        })
                        .then(res =>res.json())
                        .then(data =>{
                           
                           $('#modalLarge').modal('hide');
                           $('body').removeClass('modal-open');
                           $('.modal-backdrop').remove();
                           this.article.title='';
                           this.article.body='';
                           // alert('Article Added');
                           this.fetchArticles();
                           
                        })
                        .catch(err => console.log(err));
                        
                     }
                     else{
                        // Update
                        console.log("Came here");
                        
                        fetch('api/article',{
                           method: 'put',
                           body: JSON.stringify(this.article),
                           headers:{
                              'content-type': 'application/json'
                           }
                        })
                        .then(res =>res.json())
                        .then(data =>{
                           $('.modal-backdrop').remove();
                           this.article.title='';
                           this.article.body='';
                           // alert('Article Updated');
                           $('#modalLarge').modal('hide');
                           $('body').removeClass('modal-open');
                           $('.modal-backdrop').remove();
                           this.fetchArticles(this.current_page_url);
                        })
                        .catch(err => console.log(err));
                        this.edit = false;
                        this.article.id = '';
                        this.article.article_id = '';
                        this.article.title = '';
                        this.article.body = '';
                        
         
                     }
                     
                  },
                  
         
                  editArticle(article) {
                     $('#modalLarge').modal('show');
                     this.edit = true;
                     this.article.id = article.id;
                     this.article.article_id = article.id;
                     this.article.title = article.title;
                     this.article.body = article.body;
                  },
                  
               },
               computed: {
                     filteredArticles:function(){
                        return this.articles.filter((article) =>{
                           console.log(this.search);
                           return ((article.title).toLowerCase()).match(((this.search).toLowerCase())) || ((article.body).toLowerCase()).match(((this.search).toLowerCase()));
                        });
                     }
                  }
         
            }
            
   </script>
   
