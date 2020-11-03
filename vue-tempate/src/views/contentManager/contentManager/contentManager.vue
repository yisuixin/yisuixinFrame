<template>
    <div>
        <Card :bordered="false" dis-hover style="margin-bottom: 10px;">
            <div class="category-btn-list">
                <Form ref="search" :model="search" :label-width="100">
                    <Row>
                        <Col span="6">
                            <FormItem label="标题："prop="title">
                                <Input type="text" v-model="search.title" placeholder="请输入标题"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="作者："prop="author">
                                <Input type="password" v-model="search.author" placeholder="请输入作者"></Input>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="发布时间：" prop="releaseTime" >
                                <DatePicker type="daterange" placeholder="请选择发布时间" v-model="search.releaseTime":editable="false"></DatePicker>
                            </FormItem>
                        </Col>
                        <Col span="6">

                        </Col>
                    </Row>
                    <Row>
                        <Col span="6">
                            <FormItem label="所属栏目：" prop="releaseTime" >
                                <Select v-model="search.category" >
                                    <Option v-for="item in categoryList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="是否置顶：" prop="topping" >
                                <Select v-model="search.topping" >
                                    <Option value="1" >是</Option>
                                    <Option value="2" >否</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="8">
                            <FormItem>
                                <Button type="primary" @click="handleSubmit('search')">搜索</Button>
                                <Button type="default" @click="handleSubmit('search')">重置</Button>
                            </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
        </Card>
        <Card :bordered="false" dis-hover>
            <Button type="dashed" icon="md-add" long class="add-content-btn" title="添加内容">添加内容</Button>
            <List item-layout="vertical">
                <ListItem v-for="item in data" :key="item.id">
                    <ListItemMeta>
                        <template slot="title">
                            <a href="" class="content-title">{{item.title}}</a>
                            <p class="content-info">
                                <span class="author">作者：{{item.author}}</span>
                                <span class="category">栏目：{{item.category}}</span>
                                <span class="releaseTime">发布时间：{{item.releaseTime}}</span>
                            </p>
                        </template>
                    </ListItemMeta>
                    <div class="content">
                        {{ item.description }}
                    </div>
                    <div class="content-tag">
                        <Tag>iView</Tag>
                        <Tag>Vue.js</Tag>
                        <Tag>Webpack</Tag>
                    </div>
                    <template slot="action">
                        <li title="收藏数">
                            <Icon type="ios-star-outline"/> 123
                        </li>
                        <li title="点赞数">
                            <Icon type="ios-thumbs-up-outline" /> 234
                        </li>
                        <li title="评论数">
                            <Icon type="ios-chatbubbles-outline"  /> 345
                        </li>
                        <li title="修改" class="contentMangeBtn">
                            <Icon type="ios-brush" /> 修改
                        </li>
                        <li title="置顶" class="contentMangeBtn">
                            <Icon type="md-arrow-round-up" /> 置顶
                        </li>
                        <li title="删除" class="contentMangeBtn">
                            <Icon type="ios-trash" /> 删除
                        </li>
                    </template>
                    <template slot="extra">
                        <img src="https://dev-file.iviewui.com/5wxHCQMUyrauMCGSVEYVxHR5JmvS7DpH/large" style="width: 280px">
                    </template>
                </ListItem>
            </List>
            <!--      <Table :border="false" :columns="categoryColumns" :data="categoryData" >-->
            <!--        <template slot-scope="{ row, index }" slot="action">-->
            <!--          <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>-->
            <!--          <Button type="error" size="small" @click="remove(index)">删除</Button>-->
            <!--        </template>-->
            <!--        <template slot-scope="{ row }" slot="name">-->
            <!--          <strong>{{ row.name }}</strong>-->
            <!--        </template>-->
            <!--        <template slot-scope="{ row, index }" slot="action">-->
            <!--          <Button type="primary" size="small" style="margin-right: 5px" @click="show(index)">编辑</Button>-->
            <!--          <Button type="error" size="small" @click="remove(index)">删除</Button>-->
            <!--        </template>-->
            <!--      </Table>-->
            <div class="page-box"><Page :total="100" show-elevator show-sizer /></div>
        </Card>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                categoryList: [
                    {
                        value: 'New York',
                        label: 'New York'
                    },
                    {
                        value: 'London',
                        label: 'London'
                    },
                    {
                        value: 'Sydney',
                        label: 'Sydney'
                    },
                    {
                        value: 'Ottawa',
                        label: 'Ottawa'
                    },
                    {
                        value: 'Paris',
                        label: 'Paris'
                    },
                    {
                        value: 'Canberra',
                        label: 'Canberra'
                    }
                ],
                search: {
                    title: '',
                    author: '',
                    releaseTime: '',
                    category:'',
                    topping:''
                },
                data: [
                    {
                        title: '写给 iView 开发者的一封信1',
                        category:'文章管理',
                        description: '你好，亲爱的 iView 开发者（准开发者），很高兴你能使用到我们新上线的 iView 开发者社区。iView 从立项到现在已经经历了两年的时间，7 月 28 日是它两周岁的生日，在这一天，我们荣幸的召开了新品发布会并发布了 iView 3.0。对于初入社区的你，这篇文章将是一个很好的导引，下面就带你玩转 iView Developer。',
                        avatar: 'https://dev-file.iviewui.com/userinfoPDvn9gKWYihR24SpgC319vXY8qniCqj4/avatar',
                        content: 'This is the content, this is the content, this is the content, this is the content.',
                        author:'张三',
                        releaseTime:'2018-07-17 23:27:00'
                    },
                    {
                        title: '脱离 Table 组件的 Render 苦海',
                        category:'文章管理',
                        description: '在具体开发过程中，有些使用变扭的地方（和iview无关），比如 Table 组件的自定义列实现复杂，可展开 Table 不想单独建一个 vue 文件等。 在项目开发过程中发现的小技巧分享给大家，可提高代码编写效率与可维护性。',
                        avatar: 'https://dev-file.iviewui.com/userinfoPDvn9gKWYihR24SpgC319vXY8qniCqj4/avatar',
                        content: 'This is the content, this is the content, this is the content, this is the content.',
                        author:'李四',
                        releaseTime:'2018-07-17 23:27:00'
                    },
                    {
                        title: '写给 iView 开发者的一封信3',
                        category:'文章管理',
                        description: 'This is description, this is description, this is description.',
                        avatar: 'https://dev-file.iviewui.com/userinfoPDvn9gKWYihR24SpgC319vXY8qniCqj4/avatar',
                        content: 'This is the content, this is the content, this is the content, this is the content.',
                        author:'王五',
                        releaseTime:'2018-07-17 23:27:00'
                    }
                ],
                categoryColumns: [
                    {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    },
                    {
                        title: '排序',
                        key: 'sort',
                        width:100,
                        align:'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Input', {
                                    style: {
                                        padding: '8px'
                                    },
                                    props: {
                                        value: this.categoryData[params.index].sort
                                    },
                                    on: {
                                        'on-change': (event) => {
                                            console.log(this.categoryData[params.index].name)
                                        }
                                    }
                                })
                            ])
                        }
                    },
                    {
                        title: 'ID',
                        key: 'id',
                        width:120,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '标题',
                        key: 'titleName',
                        width:600,
                        align:'left',
                        // render: (h, params) => {
                        //   return h('div', {style:{paddingLeft:this.categoryData[params.index].id+'px'}}, this.categoryData[params.index].name)
                        // }
                    },
                    {
                        title: '阅读数',
                        key: 'redNumber',
                        width:120,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '发布人',
                        key: 'author',
                        width:120,
                        align:'center'
                    },
                    {
                        title: '发布时间',
                        key: 'releaseTime',
                        width:200,
                        align:'center',
                        sortable: true
                    },
                    {
                        title: '管理操作',
                        slot: 'action',
                        align: 'center',
                        key: 'action'
                    }
                ],
                categoryData: [{
                    sort: 1,
                    id: 1,
                    titleName: '栏目名称',
                    redNumber:1,
                    author:'张三',
                    releaseTime:'2020-8-15 11:23',
                },
                    {
                        sort: 1,
                        id: 2,
                        titleName: '栏目名称',
                        redNumber:1,
                        author:'张三',
                        releaseTime:'2020-8-15 11:23',
                    },
                    {
                        sort: 1,
                        id: 3,
                        titleName: '栏目名称',
                        redNumber:1,
                        author:'张三',
                        releaseTime:'2020-8-15 11:23',
                    },
                    {
                        sort: 1,
                        id: 4,
                        titleName: '栏目名称',
                        redNumber:1,
                        author:'张三',
                        releaseTime:'2020-8-15 11:23',
                    },
                    {
                        sort: 1,
                        id: 5,
                        titleName: '栏目名称',
                        redNumber:1,
                        author:'张三',
                        releaseTime:'2020-8-15 11:23',
                    },
                    {
                        sort: 1,
                        id: 6,
                        titleName: '栏目名称',
                        redNumber:1,
                        author:'张三',
                        releaseTime:'2020-8-15 11:23',
                    },
                ],
            }
        },
        methods: {
            //点击排序
            updateSort:function(){
                console.log(3333)
            }
            // show (index) {
            //     this.$Modal.info({
            //         title: 'User Info',
            //         content: `Name：${this.data6[index].name}<br>Age：${this.data6[index].age}<br>Address：${this.data6[index].address}`
            //     })
            // },
            // remove (index) {
            //     this.data6.splice(index, 1);
            // }
        }
    }
</script>
<style scoped>
    @import "../../../assets/style/content.css";
</style>