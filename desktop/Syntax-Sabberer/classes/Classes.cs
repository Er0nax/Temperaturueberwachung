using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Syntax_Sabberer.classes
{
    public class ApiResponse
    {
        public int Status { get; set; }
        public bool Cached { get; set; }
        public List<object> Response { get; set; }
    }
}
