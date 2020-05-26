module.exports = {
  title: 'Todolist docs',
  description: 'Todolist API documentation',
  themeConfig: {
    repo: 'guillaumebriday/todolist-backend-laravel',
    docsRepo: 'guillaumebriday/todolist-backend-laravel',
    docsDir: 'docs',
    editLinks: true,
    lastUpdated: true,
    serviceWorker: true,
    nav: [
      { text: 'API', link: '/api/' },
    ],
    sidebar: {
      '/api/': [
        {
          title: 'API',
          collapsable: false,
          children: [
            '',
            'users',
            'tasks'
          ]
        }
      ]
    }
  }
}
