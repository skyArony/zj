# 使用介绍

本系统为**「教育信息化课程定制系统 \ 科研组队系统」**，主要提供**「个性化课程定制」**和**「科研课题组队」**两大功能。



### 如何注册和登陆

本系统用户基于 [**世界大学城**](http://worlduc.com/) 用户体系，使用世界大学城账户进行登录即可使用，首次使用需要先在 [**本系统登录**](http://zj.yfree.ccc/admin/login) 一次。

首次登录成功后，以后可以使用以下三种方式任意一种再次登录系统：

1. [**大学城账密登录** ](http://zj.yfree.ccc/admin/login) 
2. [**QQ 登录**](http://zj.yfree.ccc/admin/login) ：需先进行 QQ [**绑定**](http://zj.yfree.ccc/#/index/me)
3. 大学城登录后直接跳转：需在大学城先进行配置，配置方法看最下面附录



### 具体功能介绍

#### 个性化课程定制

1. 教师从大学城同步课程
2. 教师从大学城同步课程目录
3. 教师添加题库题目，系统自动组卷
4. 学生填写问卷，自动生成个性化课程大纲和学习计划，并支持导出 PDF

#### 科研课题组队

1. 教师发布课题
2. 学生组建团队
3. 队长报名
4. 队长提交科研申请书
5. 教师点评申请书，选择通过或驳回
6. 申请书通过的团队提交科研成果



### 附

#### 如何在设置大学城直接跳转登陆？

> 设置大学城直接跳转登陆，需先在系统登录过一次。

1. [在此](http://worlduc.com/SpaceManage/CustomMenu/TopMenu.aspx) 添加一了栏顶部导航，**务必移动到第一项**

   > 名称：教育信息化系统
   >
   > 链接：http://zj.yfree.cc/worlduc/login

![image-20190406170003255](/storage/img/image-20190406170003255.png)

2. [在此](http://worlduc.com/SpaceManage/Decoration/SetPage.aspx) 装扮空间
   - 选择下面的「高级设置」- 「空间代码」
   - 粘贴如下代码，并保存

```html
<script type="text/javascript">
  var uid = jQuery('#Hid_UserID')[0].value;
  jQuery('#U_Navigation > ul > li > a')[0].href = 'http://zj.yfree.cc/worlduc/login?uid=' + uid;
</script>
```

![image-20190406170100977](/storage/img/image-20190406170100977.png)

3. 然后在空间导航栏上点击 「[教育信息化系统](http://zj.yfree.cc/worlduc/login?uid=2708895)」即可

   ![image-20190406170214779](/storage/img/image-20190406170214779.png)





### 视频功能介绍

#### 个性化课程定制

- 注册和登录
- 课程同步
- 题库和自动组卷
- 学习大纲生成和导出

#### 科研课题组队

- 发布课题
- 组建团队和报名
- 申请书提交和审核
- 科研成果提交和查看

