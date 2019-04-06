<template>
  <div class="page-content browse container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-body">
        <h1>使用介绍</h1>
        <p>
          本系统为
          <strong>「教育信息化课程定制系统 \ 科研组队系统」</strong>，主要提供
          <strong>「个性化课程定制」</strong>和
          <strong>「科研课题组队」</strong>两大功能。
        </p>
        <p>&nbsp;</p>
        <h3>如何注册和登陆</h3>
        <p>
          本系统用户基于
          <a href="http://worlduc.com/">
            <strong>世界大学城</strong>
          </a>
          用户体系，使用世界大学城账户进行登录即可使用，首次使用需要先在
          <a href="http://zj.yfree.ccc/admin/login">
            <strong>本系统登录</strong>
          </a>
          一次。
        </p>
        <p>首次登录成功后，以后可以使用以下三种方式任意一种再次登录系统：</p>
        <ol>
          <li>
            <a href="http://zj.yfree.ccc/admin/login">
              <strong>大学城账密登录</strong>
            </a>
          </li>
          <li>
            <a href="http://zj.yfree.ccc/admin/login">
              <strong>QQ 登录</strong>
            </a>
            ：需先进行 QQ
            <a href="http://zj.yfree.ccc/#/index/me">
              <strong>绑定</strong>
            </a>
          </li>
          <li>大学城登录后直接跳转：需在大学城先进行配置，配置方法看最下面附录</li>
        </ol>
        <p>&nbsp;</p>
        <h3>具体功能介绍</h3>
        <h4>个性化课程定制</h4>
        <ol>
          <li>教师从大学城同步课程</li>
          <li>教师从大学城同步课程目录</li>
          <li>教师添加题库题目，系统自动组卷</li>
          <li>学生填写问卷，自动生成个性化课程大纲和学习计划，并支持导出 PDF</li>
        </ol>
        <h4>科研课题组队</h4>
        <ol>
          <li>教师发布课题</li>
          <li>学生组建团队</li>
          <li>队长报名</li>
          <li>队长提交科研申请书</li>
          <li>教师点评申请书，选择通过或驳回</li>
          <li>申请书通过的团队提交科研成果</li>
        </ol>
        <p>&nbsp;</p>
        <h3>附</h3>
        <h4>如何在设置大学城直接跳转登陆？</h4>
        <blockquote>
          <p>设置大学城直接跳转登陆，需先在系统登录过一次。</p>
        </blockquote>
        <ol>
          <li>
            <p>
              <a href="http://worlduc.com/SpaceManage/CustomMenu/TopMenu.aspx">在此</a>
              添加一了栏顶部导航，
              <strong>务必移动到第一项</strong>
            </p>
            <blockquote>
              <p>名称：教育信息化系统</p>
              <p>
                链接：
                <a href="http://zj.yfree.cc/worlduc/login"
                   target="_blank"
                   class="url">http://zj.yfree.cc/worlduc/login</a>
              </p>
            </blockquote>
          </li>
        </ol>
        <p>
          <img src="/storage/img/image-20190406170003255.png"
               alt="image-20190406170003255"
               referrerPolicy="no-referrer" />
        </p>
        <ol start="2">
          <li>
            <p>
              <a href="http://worlduc.com/SpaceManage/Decoration/SetPage.aspx">在此</a>
              装扮空间
            </p>
            <ul>
              <li>选择下面的「高级设置」- 「空间代码」</li>
              <li>粘贴如下代码，并保存</li>
            </ul>
          </li>
        </ol>
        <pre><code class='language-html' lang='html'>&lt;script type=&quot;text/javascript&quot;&gt;
  var uid = jQuery(&#39;#Hid_UserID&#39;)[0].value;
  jQuery(&#39;#U_Navigation &gt; ul &gt; li &gt; a&#39;)[0].href = &#39;http://zj.yfree.cc/worlduc/login?uid=&#39; + uid;
&lt;/script&gt;
</code></pre>
        <p>
          <img src="/storage/img/image-20190406170100977.png"
               alt="image-20190406170100977"
               referrerPolicy="no-referrer" />
        </p>
        <ol start="3">
          <li>
            <p>
              然后在空间导航栏上点击 「
              <a href="http://zj.yfree.cc/worlduc/login?uid=2708895">教育信息化系统</a>」即可
            </p>
            <p>
              <img src="/storage/img/image-20190406170214779.png"
                   alt="image-20190406170214779"
                   referrerPolicy="no-referrer" />
            </p>
          </li>
        </ol>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <h3>视频功能介绍</h3>
        <h4>个性化课程定制</h4>
        <ul>
          <li>注册和登录</li>
          <li>课程同步</li>
          <li>题库和自动组卷</li>
          <li>学习大纲生成和导出</li>
        </ul>
        <h4>科研课题组队</h4>
        <ul>
          <li>发布课题</li>
          <li>组建团队和报名</li>
          <li>申请书提交和审核</li>
          <li>科研成果提交和查看</li>
        </ul>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style scoped>
</style>
