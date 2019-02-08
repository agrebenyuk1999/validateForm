<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<br>
<div class="container" id="app">
    <div class="row">

        <form style="width: 100%" method="post">
            <div class="form-group row">
                <label for="title" class="col-md-2 col-form-label">Заголовок</label>
                <div class="col-md-10">
                    <input
                            type="text"
                            class="form-control"
                            :class="{'is-invalid': errors['title']}"
                            id="title"
                            name="title"
                            v-model="title"
                    >
                    <div class="invalid-feedback">
                        {{ errors['title'] ? errors['title'][0] : '' }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="annotation" class="col-md-2 col-form-label">Аннотация</label>
                <div class="col-md-10">
                    <textarea
                        name="annotation"
                        id="annotation"
                        class="form-control"
                        :class="{'is-invalid': errors['annotation']}"
                        v-model="annotation"
                        cols="30"
                        rows="10"></textarea>
                    <div class="invalid-feedback"> {{ errors['annotation'] ? errors['annotation'][0] : '' }} </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="content" class="col-md-2 col-form-label">Текст новости</label>
                <div class="col-md-10">
                    <textarea
                        name="content"
                        id="content"
                        class="form-control"
                        :class="{'is-invalid': errors['content']}"
                        v-model="content"
                        cols="30"
                        rows="10"></textarea>
                    <div class="invalid-feedback"> {{ errors['content'] ? errors['content'][0] : '' }} </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-2 col-form-label">Email  автора для связи</label>
                <div class="col-md-10">
                    <input
                        type="text"
                        class="form-control"
                        :class="{'is-invalid' : errors['email']}"
                        v-model="email"
                        id="email"
                        name="email"
                        value=""
                    >
                    <div class="invalid-feedback">
                        {{ errors['email'] ? errors['email'][0] : '' }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="views" class="col-md-2 col-form-label">Кол-во просмотров</label>
                <div class="col-md-10">
                    <input
                        type="text"
                        class="form-control"
                        :class="{'is-invalid' : errors['views']}"
                        v-model="views"
                        id="views"
                        name="views"
                        value=""
                    >
                    <div class="invalid-feedback">
                        {{ errors['views'] ? errors['views'][0] : '' }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="date" class="col-md-2 col-form-label">Дата публикации</label>
                <div class="col-md-10">
                    <input
                        type="date"
                        class="form-control"
                        :class="{'is-invalid' : errors['date']}"
                        v-model="date"
                        id="date"
                        name="date"
                        value=""
                    >
                    <div class="invalid-feedback">
                        {{ errors['date'] ? errors['date'][0] : '' }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="is_publish" class="col-md-2 col-form-label">Публичная новость</label>
                <div class="col-md-10">
                    <input
                        type="checkbox"
                        class="form-control"
                        id="is_publish"
                        name="is_publish"
                    >
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Публиковать на главной</label>
                <div class="col-md-10">
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                :class="{'is-invalid' : errors['publish_in_index']}"
                                v-model="publish_in_index"
                                type="radio"
                                name="publish_in_index"
                                id="publish_in_index_yes"
                                value="yes"
                        >
                        <label class="form-check-label" for="publish_in_index_yes">
                            Да
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                :class="{'is-invalid' : errors['publish_in_index']}"
                                v-model="publish_in_index"
                                type="radio"
                                name="publish_in_index"
                                id="publish_in_index_no"
                                value="no"
                        >
                        <label class="form-check-label" for="publish_in_index_no">
                            Нет
                        </label>
                    </div>
                    <div class="invalid-feedback">
                        {{ errors['publish_in_index'] ? errors['publish_in_index'][0] : '' }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="category" class="col-md-2 col-form-label">Категория</label>
                <div class="col-md-10">
                    <select id="category" class="form-control" :class="{'is-invalid' : errors['category']}" name="category" v-model="category">
                        <option disabled selected>Выберете категорию из списка..</option>
                        <option value="1">Спорт</option>
                        <option value="2">Культура</option>
                        <option value="3">Политика</option>
                    </select>
                    <div class="invalid-feedback"> {{ errors['category'] ? errors['category'][0] : '' }} </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-9">
                    <button type="button" @click="send()" class="btn btn-primary">Отправить</button>
                </div>
                <div class="col-md-3" v-if="isValid === true">
                    <div class="alert alert-success">Форма валидна</div>
                </div>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    axios.defaults.transformRequest = [function (data, headers) {
        var str = [];
        for(var p in data)
            if (data.hasOwnProperty(p) && data[p]) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(data[p]));
            }
        return str.join("&");
    }];
    var app = new Vue({
        el: '#app',
        data: {
            title: null,
            isValid: null,
            annotation: null,
            content: null,
            email: null,
            views: null,
            date: null,
            publish_in_index: null,
            category: null,
            errors: [],
        },
        methods: {
            send() {
                axios.post('validator.php', this.getFormFields).then(response => {
                    if (response.data.status) {
                        this.errors = [];
                        this.isValid = true;
                    }else {
                        this.isValid = false;
                        this.errors = response.data.errors;
                    }
                });
            }
        },
        computed: {
            getFormFields() {
                return {
                    title: this.title,
                    annotation: this.annotation,
                    content: this.content,
                    email: this.email,
                    views: this.views,
                    date: this.date,
                    publish_in_index: this.publish_in_index,
                    category: this.category,
                    isValid: this.isValid,
                }
            }
        }
    })
</script>
</body>
</html>