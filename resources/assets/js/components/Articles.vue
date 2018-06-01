<template>

      <div>
         <h2>Articles</h2>

         <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target=".bd-example-modal-lg" @click="clearArticle()">Add</button>

         <div class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-centered">
                 <div class="modal-content">
                     <form @submit.prevent="addArticle" class="mb-3">
                           <div class="form-group modal-header">
                             <input type="text" class="form-control" placeholder="Title" v-model="article.title">
                           </div>
                     
                           <div class="form-group modal-body">
                                 <code><textarea type="text" class="form-control" placeholder="Body" v-model="article.body"></textarea></code>
                           </div>
                     
                           <div class="modal-footer">
                                 <button @click="stopEditing" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit">Save</button>
                           </div>

                        </form>
                 </div>
               </div>
             </div>

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
                       <small class="text-muted">9 mins</small>
                     </div>
                   </div>
                 </div>
               </div>
         </div>

         <!-- This is for testing -->

         <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modalLarge">
               Large Demo Modal
           </button>

           <div class="modal fade modal-fullscreen" id="modalLarge" tabindex="-1" role="dialog" aria-labelledby="modalLargeLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="modalLargeLabel">Modal with large content</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       <div class="modal-body">
                           <p>
                               Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed dui tempor, finibus ligula vitae, convallis mi. Sed posuere
                               at neque nec hendrerit. Sed vitae felis gravida, ultricies dui eget, venenatis leo. Nunc hendrerit tellus
                               non velit malesuada, eu dapibus sapien placerat. Sed non viverra magna, sit amet ornare erat. Fusce eros
                               mi, consequat ac elit vel, ullamcorper molestie mauris. Proin auctor orci eget lacinia condimentum. Phasellus
                               ultricies ligula id lacinia posuere. Nulla rutrum eros eu arcu tempor, imperdiet ornare lectus convallis.
                               Nulla eleifend dapibus sem, vel viverra sapien.
                           </p>
                           <p>
                               Integer interdum ex augue, vel egestas nibh fermentum eu. Cras ut erat eu nisi ullamcorper scelerisque vitae in lorem. In
                               hac habitasse platea dictumst. Pellentesque in ante aliquam, porta metus eu, viverra magna. Cras blandit,
                               augue in consequat rhoncus, nulla risus sodales mi, at tincidunt dolor leo semper mauris. Class aptent
                               taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus pellentesque purus
                               porta maximus blandit. Suspendisse id lorem pellentesque, vehicula nulla at, congue eros. Duis eleifend
                               semper sodales. Morbi eu sagittis ex. Praesent commodo rhoncus nisi. Aenean quis arcu mauris.
                           </p>
                           <p>
                               Donec eget ex ut nibh ullamcorper commodo. Aenean ac faucibus mi. Nullam luctus dui diam, in congue sem fringilla et. Vivamus
                               non metus at elit ornare maximus. Nam iaculis ex in dolor rutrum, at facilisis dolor euismod. Sed lacinia
                               sagittis lobortis. Suspendisse turpis tellus, pharetra scelerisque odio eget, condimentum tempus nibh.
                               Praesent in diam ac sapien dignissim luctus a quis sapien. Duis sed lacus magna. Maecenas at fringilla
                               quam. Ut purus risus, ultricies eget risus ut, convallis hendrerit eros. Fusce vehicula libero quam,
                               nec cursus nulla interdum eu. Quisque commodo suscipit justo, id auctor metus varius rutrum.
                           </p>
                           <p>
                               Integer et fermentum sapien. Proin eu eros efficitur, malesuada ipsum vel, tincidunt risus. Proin cursus laoreet varius.
                               Donec eros sapien, accumsan ac facilisis id, egestas quis turpis. Mauris dignissim, sem et pellentesque
                               consequat, erat dui tempus nulla, ut laoreet neque ligula ac libero. Interdum et malesuada fames ac ante
                               ipsum primis in faucibus. Mauris dictum accumsan erat et tempus. Pellentesque ac ipsum at dui blandit
                               mollis. Suspendisse a turpis non velit commodo iaculis. Donec sit amet sem risus. Nunc pharetra lacus
                               vitae faucibus mattis. Vestibulum molestie, quam et efficitur consequat, dui nibh pulvinar sapien, sit
                               amet pharetra mauris sem sed massa.
                           </p>
                           <p>
                               In tempus neque vitae magna congue, convallis blandit dolor mollis. Fusce rutrum in diam ac pretium. Vivamus sagittis, elit
                               at cursus lacinia, mauris urna feugiat quam, et tincidunt nulla justo eget dui. Nullam malesuada felis
                               quis dolor aliquam scelerisque. Maecenas porta, neque sit amet auctor bibendum, urna nibh porta enim,
                               et auctor turpis ligula vel quam. In vulputate eu erat quis bibendum. Mauris vel felis luctus, ultricies
                               nulla ac, euismod diam.
                           </p>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="button" id="btnTestSaveLarge" class="btn btn-default">
                               <span class="d-none d-md-inline">Save changes</span>
                               <span class="d-md-none">Save</span>
                           </button>
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
                  search: ""
               }
            },
      
            created() {
               this.fetchArticles();
            },
      
            methods: {
               stopEditing(){
                  this.edit = false;
               },
               fetchArticles(page_url){
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

                        this.fetchArticles();
                        
                     })
                     .catch(err => console.log(err));
                  }
               },
               clearArticle(){
                  this.edit=false;
                  this.article.id = '';
                  this.article_id = '';
                  this.article.title = '';
                  this.article.body = '';
               },
      
               addArticle() {
                  this.search = "";
                  
                  
                  if (this.edit == false){
                     
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
                        this.fetchArticles();
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
                  $('.bd-example-modal-lg').modal('show');
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

