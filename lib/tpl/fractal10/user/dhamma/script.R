library(igraph)
library(magrittr)
library(visNetwork)
library(data.table)

#### Collect the Data and create graph object

mydata <- read.csv('/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/dhamma/links.csv', head = T)
nodesOrigin <- data.frame(read.csv(file = '/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/dhamma/nodes.csv'))

move = names(mydata)[names(mydata) == "from" | names(mydata)== "to"]
setcolorder(mydata, c(move, setdiff(names(mydata), move)))

mydata<-mydata[!(mydata$from=="" | mydata$to==""),]    ### removes rows with broken links

graph <- graph.data.frame(mydata, directed=T)
graphF <- graph.data.frame(mydata, directed=F)

graph <- simplify(graph)
graphF <- simplify(graphF)

#print_all(graph)

#### Create colors for community (this used only links to create the graph, no oprhean node will show)

fc <- fastgreedy.community(graphF)    ### seems not to accept directed graph
V(graph)$community <- fc$membership   ### seems to work, don't ask me why...
nodes <- data.frame(id = V(graph)$name, title = V(graph)$name, group = V(graph)$community)
nodes <- nodes[order(nodes$id, decreasing = F),]
edges <- get.data.frame(graph, what="edges")[1:2]

#### Create the sizing of nodes according to number of edges attached

degree_value <- degree(graph, mode = "total")
nodes$value <- degree_value[match(nodes$id, names(degree_value))]
nodes[is.na(nodes)] <- 0
nodes$pageId <- nodesOrigin$pageId[match(nodes$id, nodesOrigin$id)]
nodes <- na.omit(nodes) ### remove the exclude pages that have no pageid
nodes$shadow <- TRUE    ### Nodes will drop shadow
nodesOrigin$shadow <- TRUE    ### Nodes will drop shadow
edges$arrows <- "to"    ### arrows: 'from', 'to', or 'middle'

### add opreahn

nodes <- merge(nodes, nodesOrigin,all = TRUE)
nodes[is.na(nodes)] <- 0

### Create network with parameters

network <- visNetwork(nodes, edges) %>%
      visPhysics(solver = "forceAtlas2Based", forceAtlas2Based = list(gravitationalConstant = -30))%>%
      visNodes(size = 30)%>%
      visOptions(highlightNearest = TRUE,
                 nodesIdSelection = list(selected = "Noble Truth of Dukkha"))%>%
      visLayout(randomSeed = 1245)%>%
      visInteraction(dragNodes = T, dragView = FALSE, zoomView = FALSE)%>%
      visEvents(selectNode =
                  "function(params) {
                    var nodeID = params.nodes[0];
                    var url = this.body.nodes[nodeID].options.pageId;
                    location.href = url;
                   }")

### save network

visSave(network, file = "/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/dhamma/network.html", selfcontained = F)
