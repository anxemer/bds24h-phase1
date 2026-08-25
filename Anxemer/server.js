const http = require('http');
const { URL } = require('url');

const PORT = process.env.PORT || 3000;

const projects = [
  {
    slug: 'phuoc-dong',
    name: 'KCN Cau cang Phuoc Dong',
    location: 'Can Giuoc, Long An',
    region: 'long-an',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: '$142 - $163/m2',
    industries: ['Co khi', 'Logistics'],
    area: '128 ha',
  },
  {
    slug: 'huu-thanh',
    name: 'KCN Huu Thanh (IDICO)',
    location: 'Duc Hoa, Long An',
    region: 'long-an',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: '$158 - $163/m2',
    industries: ['Dien tu', 'R&D', 'Logistics'],
    area: '524 ha',
  },
  {
    slug: 'tan-phu-trung',
    name: 'KCN Tan Phu Trung',
    location: 'Cu Chi, TP. Ho Chi Minh',
    region: 'hcm',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: 'Tu $265/m2',
    industries: ['Cong nghe cao', 'San xuat sach'],
    area: '542 ha',
  },
  {
    slug: 'phu-my-ii',
    name: 'KCN Phu My II',
    location: 'Phu My, Ba Ria - Vung Tau',
    region: 'ba-ria',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: 'Tu $137/m2',
    industries: ['Cang bien', 'Logistics'],
    area: '620 ha',
  },
  {
    slug: 'chau-duc',
    name: 'KCN Chau Duc',
    location: 'Chau Duc, Ba Ria - Vung Tau',
    region: 'ba-ria',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: '$80 - $125/m2',
    industries: ['Dien tu', 'Duoc pham', 'Co khi'],
    area: '2,287 ha',
  },
  {
    slug: 'binh-chieu',
    name: 'KCN Binh Chieu',
    location: 'Thu Duc, TP. Ho Chi Minh',
    region: 'hcm',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: '$300 - $330/m2',
    industries: ['Co khi', 'Dien tu'],
    area: '27 ha',
  },
  {
    slug: 'le-minh-xuan-3',
    name: 'KCN Le Minh Xuan 3',
    location: 'Binh Chanh, TP. Ho Chi Minh',
    region: 'hcm',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: '$320 - $400/m2',
    industries: ['IT', 'Khuon mau', 'Kho van'],
    area: '231 ha',
  },
  {
    slug: 'hiep-phuoc',
    name: 'KCN Hiep Phuoc',
    location: 'Nha Be, TP. Ho Chi Minh',
    region: 'hcm',
    status: 'operating',
    type: 'Khu cong nghiep',
    price: 'Tu $250/m2',
    industries: ['Cang', 'Hang hai', 'Logistics'],
    area: '1,686 ha',
  },
];

const news = [
  {
    id: 1,
    title: 'Moi gioi kho xuong Quang Tri: Cong ty nao chuyen va uy tin?',
    category: 'Tin thi truong',
    date: '2026-08-08',
  },
  {
    id: 2,
    title: 'Ky gui nha xuong Quang Tri: Dich vu uy tin',
    category: 'Tin thi truong',
    date: '2026-08-07',
  },
  {
    id: 3,
    title: 'KCN QTIP Quang Tri: Cho thue dat KCN, kho xuong',
    category: 'Khu cong nghiep',
    date: '2026-08-06',
  },
];

function sendJson(response, statusCode, payload) {
  response.writeHead(statusCode, {
    'Content-Type': 'application/json; charset=utf-8',
    // 'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Origin': '*',
    'Access-Control-Allow-Methods': 'GET,POST,OPTIONS',
    'Access-Control-Allow-Headers': 'Content-Type',
  });
  response.end(JSON.stringify(payload));
}

function readJson(request) {
  return new Promise((resolve, reject) => {
    let body = '';

    request.on('data', (chunk) => {
      body += chunk;
      if (body.length > 1_000_000) {
        reject(new Error('Request body too large'));
        request.destroy();
      }
    });

    request.on('end', () => {
      if (!body) return resolve({});
      try {
        resolve(JSON.parse(body));
      } catch {
        reject(new Error('Invalid JSON'));
      }
    });

    request.on('error', reject);
  });
}

function filterProjects(searchParams) {
  const keyword = (searchParams.get('search') || '').trim().toLowerCase();
  const region = searchParams.get('region') || 'all';
  const status = searchParams.get('status') || 'all';

  return projects.filter((project) => {
    const searchableText = `${project.name} ${project.location} ${project.industries.join(' ')}`.toLowerCase();
    const matchesKeyword = !keyword || searchableText.includes(keyword);
    const matchesRegion = region === 'all' || project.region === region;
    const matchesStatus = status === 'all' || project.status === status;
    return matchesKeyword && matchesRegion && matchesStatus;
  });
}

const server = http.createServer(async (request, response) => {
  if (request.method === 'OPTIONS') {
    return sendJson(response, 204, {});
  }

  const requestUrl = new URL(request.url, `http://${request.headers.host || 'localhost'}`);
  // const path = requestUrl.pathname.replace(/\/$/, '') || '/';
  const path = requestUrl.pathname.replace(/\/$/, '') || '/';
  if (request.method === 'GET' && path === '/') {
    return sendJson(response, 200, {
      name: 'BDS24H API',
      message: 'Backend mau cho du lieu bat dong san khu cong nghiep',
      endpoints: ['/api/health', '/api/projects', '/api/projects/:slug', '/api/news'],
    });
  }

  if (request.method === 'GET' && path === '/api/health') {
    return sendJson(response, 200, {
      ok: true,
      service: 'bds24h-backend',
      time: new Date().toISOString(),
    });
  }

  if (request.method === 'GET' && path === '/api/projects') {
    const results = filterProjects(requestUrl.searchParams);
    return sendJson(response, 200, {
      total: results.length,
      data: results,
    });
  }

  if (request.method === 'GET' && path.startsWith('/api/projects/')) {
    const slug = path.split('/').pop();
    const project = projects.find((item) => item.slug === slug);

    if (!project) {
      return sendJson(response, 404, { error: 'Khong tim thay du an' });
    }

    return sendJson(response, 200, { data: project });
  }

  if (request.method === 'GET' && path === '/api/news') {
    return sendJson(response, 200, {
      total: news.length,
      data: news,
    });
  }

  if (request.method === 'POST' && path === '/api/contact') {
    try {
      const body = await readJson(request);
      const name = typeof body.name === 'string' ? body.name.trim() : '';
      const phone = typeof body.phone === 'string' ? body.phone.trim() : '';
      const message = typeof body.message === 'string' ? body.message.trim() : '';

      if (!name || !phone) {
        return sendJson(response, 400, {
          error: 'Vui long cung cap name va phone',
        });
      }

      return sendJson(response, 201, {
        message: 'Da tiep nhan yeu cau tu van',
        data: { name, phone, message },
      });
    } catch (error) {
      return sendJson(response, 400, { error: error.message });
    }
  }

  return sendJson(response, 404, { error: 'Endpoint khong ton tai' });
});

server.listen(PORT, () => {
  console.log(`BDS24H backend dang chay tai http://localhost:${PORT}`);
});
