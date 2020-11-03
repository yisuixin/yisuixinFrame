<template>
  <div>
    <Card :bordered="false">
      <p slot="title">
        <Icon type="ios-desktop"></Icon>
        <span class="serve-info" style="margin-right: 25px;">&nbsp;系统: CentOS Linux 7.2.1511 (Core)</span>
        <span class="serve-info">已运行: 338天23小时48分钟</span>
        <span class="serve-info-button-list">
                         <template>
                            <Button type="primary" size="small" class="serve-info-button">重启服务器</Button>
                            <Button type="primary" size="small" class="serve-info-button">暂停服务器</Button>
                            <Button type="primary" size="small" class="serve-info-button">重启数据库</Button>
                            <Button type="primary" size="small" class="serve-info-button">暂停数据库</Button>
                        </template>
                       </span>
      </p>
      <Row :gutter="16">
        <Col span="3">
          <div class="serve-info-list">
            <Col span="24" class="info-name"> 负载状态</Col>
            <Col span="24">
              <i-circle :percent="80" :size="100">
                <span class="demo-Circle-inner" style="font-size:24px">80%</span>
              </i-circle>
            </Col>
            <Col span="24">运行流畅</Col>
          </div>
        </Col>
        <Col span="3">
          <div class="serve-info-list">
            <Col span="24" class="info-name"> CPU使用率</Col>
            <Col span="24">
              <i-circle :percent="80" :size="100" stroke-color="#ff5500">
                <span class="demo-Circle-inner" style="font-size:24px">80%</span>
              </i-circle>
            </Col>
            <Col span="24">1 核心</Col>
          </div>
        </Col>
        <Col span="3">
          <div class="serve-info-list">
            <Col span="24" class="info-name"> 内存使用率</Col>
            <Col span="24">
              <i-circle :percent="80" :size="100" stroke-color="#5cb85c">
                <span class="demo-Circle-inner" style="font-size:24px">80%</span>
              </i-circle>
            </Col>
            <Col span="24">528/1839 (MB)</Col>
          </div>
        </Col>
        <Col span="3">
          <div class="serve-info-list">
            <Col span="24" class="info-name"> 可用容量</Col>
            <Col span="24">
              <i-circle :percent="80" :size="100">
                <span class="demo-Circle-inner" style="font-size:24px">80%</span>
              </i-circle>
            </Col>
            <Col span="24">18G/50G</Col>
          </div>
        </Col>
      </Row>
    </Card>
  </div>
</template>
