<template>
  <div class="page-container">
    <div class="index-search-container">
      <el-input class="index-search"
                placeholder="搜索"
                prefix-icon="el-icon-search">
      </el-input>
    </div>
    <div class="index-body-container">
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <img src="/storage/img/nologin.jpg"
               class="card-image" />
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
            </div>
          </div>
        </el-card>
      </div>

      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <img src="/storage/img/bg2018.png"
               class="card-image" />
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
            </div>
          </div>
        </el-card>
      </div>

      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <img src="/storage/img/nologin.jpg"
               class="card-image" />
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
            </div>
          </div>
        </el-card>
      </div>

      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <img src="http://worlduc.com/UploadFiles/OnlineCourse/upload/9f159cad-b94a-4aab-9a60-784acf9d7195.png"
               class="card-image" />
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
            </div>
          </div>
        </el-card>
      </div>

      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <img src="/storage/img/nologin.jpg"
               class="card-image" />
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
            </div>
          </div>
        </el-card>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentDate: new Date()
    };
  }
}
</script>

<style>
.page-container {
  width: 100%;
  display: flex;
  flex-direction: column;
}
.index-search-container {
  width: 100%;
  display: flex;
}
.index-search {
  width: 60%;
  margin: 30px auto;
  text-align: center;
  justify-content: center;
}
.index-search input {
  border-radius: 20px;
}

.index-body-container {
  margin: 0 auto;
  width: 80%;
  display: flex;
  flex-wrap: wrap;
}
</style>
